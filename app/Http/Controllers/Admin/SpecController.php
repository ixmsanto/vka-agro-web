<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecController extends Controller
{
    public function store(Product $product): RedirectResponse
    {
        $product->specs()->create([
            'position' => (int) $product->specs()->max('position') + 1,
            'label' => 'Label',
            'value' => 'Value',
        ]);

        return back()->with('status', 'Spec added.');
    }

    public function update(Request $request, ProductSpec $spec): JsonResponse
    {
        $rules = ProductSpec::fieldRules();

        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(array_keys($rules))],
            'value' => $rules[$request->input('field')] ?? ['nullable'],
        ]);

        $spec->update([$validated['field'] => $validated['value'] ?? null]);

        return response()->json(['saved' => true]);
    }

    public function destroy(ProductSpec $spec): RedirectResponse
    {
        $spec->delete();

        return back()->with('status', 'Spec removed.');
    }
}
