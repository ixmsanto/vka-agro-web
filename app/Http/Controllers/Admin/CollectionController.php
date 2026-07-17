<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminResources;
use App\Support\MediaStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * One controller for products / blog / gallery / testimonials. Field edits
 * autosave over PATCH; structural changes (add, reorder, delete, image) are
 * ordinary form posts so they work with JavaScript disabled.
 */
class CollectionController extends Controller
{
    public function index(string $resource): View
    {
        $config = AdminResources::config($resource);
        $query = AdminResources::model($resource)::ordered();

        if ($resource === 'products') {
            $query->with('specs');
        }

        return view("admin.{$resource}", [
            'resource' => $resource,
            'config' => $config,
            'items' => $query->get(),
        ]);
    }

    public function store(string $resource): RedirectResponse
    {
        AdminResources::make($resource);

        return back()->with('status', 'Added a new '.AdminResources::config($resource)['singular'].'.');
    }

    /** Autosave a single field. */
    public function update(Request $request, string $resource, string $id): JsonResponse
    {
        $model = AdminResources::find($resource, $id);
        $rules = $model::fieldRules();

        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(array_keys($rules))],
            'value' => $rules[$request->input('field')] ?? ['nullable'],
        ]);

        $model->update([$validated['field'] => $validated['value'] ?? null]);

        return response()->json(['saved' => true]);
    }

    public function destroy(string $resource, string $id): RedirectResponse
    {
        $model = AdminResources::find($resource, $id);
        MediaStore::delete($model->image_path);
        $model->delete();

        return back()->with('status', 'Deleted.');
    }

    public function move(Request $request, string $resource, string $id): RedirectResponse
    {
        $request->validate(['direction' => ['required', Rule::in(['up', 'down'])]]);

        $model = AdminResources::find($resource, $id);
        $request->input('direction') === 'up' ? $model->moveUp() : $model->moveDown();

        return back();
    }

    public function image(Request $request, string $resource, string $id): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:'.implode(',', MediaStore::IMAGE_MIMES), 'max:8192'],
        ]);

        MediaStore::putOn(AdminResources::find($resource, $id), $request->file('image'));

        return back()->with('status', 'Image updated.');
    }

    public function clearImage(string $resource, string $id): RedirectResponse
    {
        $model = AdminResources::find($resource, $id);
        MediaStore::delete($model->image_path);
        $model->update(['image_path' => null]);

        return back()->with('status', 'Image removed.');
    }
}
