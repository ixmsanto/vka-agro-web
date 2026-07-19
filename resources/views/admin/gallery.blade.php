@extends('layouts.admin', ['section' => 'gallery'])

@section('title', 'Gallery')
@section('crumb', $config['crumb'])
@section('heading', $config['title'])

@section('content')
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(240px,100%),1fr));gap:16px">
        @foreach ($items as $item)
            @php $url = route('admin.collection.update', ['gallery', $item->id]); @endphp

            <div class="a-card" style="border-radius:16px;padding:14px">
                <x-admin.slot
                    :src="\App\Support\MediaStore::url($item->image_path)"
                    :upload-url="route('admin.collection.image', ['gallery', $item->id])"
                    :clear-url="$item->image_path ? route('admin.collection.image.destroy', ['gallery', $item->id]) : null"
                    label="Gallery image"
                    style="aspect-ratio:4/3;border-radius:11px"
                />

                <label class="a-label" style="margin-top:12px">
                    <span style="font-size:11.5px">Caption</span>
                    <input class="a-input" type="text" value="{{ $item->caption }}" data-autosave-url="{{ $url }}" data-field="caption" style="padding:9px 11px;border-radius:8px;font-size:13.5px">
                </label>

                {{-- The width/height selects lived here. The public gallery is a
                     masonry now: a tile's height comes from its own picture and
                     its width is the column width, so there was no per-tile size
                     left to set. col_span/row_span are still on the model and in
                     the table should that ever be wanted back. --}}

                @include('admin.partials.row-controls')
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.collection.store', 'gallery') }}" style="margin-top:18px">
        @csrf
        <button type="submit" class="a-btn">+ Add gallery tile</button>
    </form>
@endsection
