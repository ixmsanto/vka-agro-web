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

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">
                    <label class="a-label">
                        <span style="font-size:11.5px">Width</span>
                        <select class="a-input" data-autosave-url="{{ $url }}" data-field="col_span" style="padding:9px 10px;border-radius:8px;font-size:13.5px">
                            <option value="1" @selected($item->col_span === 1)>1 column</option>
                            <option value="2" @selected($item->col_span === 2)>2 columns</option>
                        </select>
                    </label>
                    <label class="a-label">
                        <span style="font-size:11.5px">Height</span>
                        <select class="a-input" data-autosave-url="{{ $url }}" data-field="row_span" style="padding:9px 10px;border-radius:8px;font-size:13.5px">
                            <option value="1" @selected($item->row_span === 1)>1 row</option>
                            <option value="2" @selected($item->row_span === 2)>2 rows</option>
                        </select>
                    </label>
                </div>

                @include('admin.partials.row-controls')
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.collection.store', 'gallery') }}" style="margin-top:18px">
        @csrf
        <button type="submit" class="a-btn">+ Add gallery tile</button>
    </form>
@endsection
