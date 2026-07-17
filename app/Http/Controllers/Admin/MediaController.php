<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medium;
use App\Support\MediaStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        return view('admin.media', [
            'slots' => Medium::slots(),
            'paths' => Medium::map(),
        ]);
    }

    public function store(Request $request, string $slot): RedirectResponse
    {
        $config = Medium::slots()[$slot] ?? abort(404);

        $request->validate([
            'file' => $config['accept'] === 'video'
                ? ['required', 'file', 'mimes:'.implode(',', MediaStore::VIDEO_MIMES), 'max:65536']
                : ['required', 'image', 'mimes:'.implode(',', MediaStore::IMAGE_MIMES), 'max:8192'],
        ]);

        MediaStore::putSlot($slot, $request->file('file'));

        return back()->with('status', $config['label'].' updated.');
    }

    public function destroy(string $slot): RedirectResponse
    {
        $config = Medium::slots()[$slot] ?? abort(404);
        MediaStore::clearSlot($slot);

        return back()->with('status', $config['label'].' removed.');
    }
}
