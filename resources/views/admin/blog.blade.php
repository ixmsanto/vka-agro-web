@extends('layouts.admin', ['section' => 'blog'])

@section('title', 'Blog')
@section('crumb', $config['crumb'])
@section('heading', $config['title'])

@section('content')
    <div style="display:flex;flex-direction:column;gap:18px">
        @foreach ($items as $item)
            @php $url = route('admin.collection.update', ['blog', $item->id]); @endphp

            <div class="a-card" style="display:flex;gap:20px;flex-wrap:wrap">
                <div style="flex:0 0 auto;width:180px">
                    <x-admin.slot
                        :src="\App\Support\MediaStore::url($item->image_path)"
                        :upload-url="route('admin.collection.image', ['blog', $item->id])"
                        :clear-url="$item->image_path ? route('admin.collection.image.destroy', ['blog', $item->id]) : null"
                        label="Cover image"
                        style="aspect-ratio:16/10"
                    />
                    @include('admin.partials.row-controls')
                </div>

                <div style="flex:1 1 320px;min-width:0;display:flex;flex-direction:column;gap:12px">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <label class="a-label">
                            <span style="font-size:11.5px">Category</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->category }}" data-autosave-url="{{ $url }}" data-field="category">
                        </label>
                        <label class="a-label">
                            <span style="font-size:11.5px">Read time</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->read_time }}" data-autosave-url="{{ $url }}" data-field="read_time">
                        </label>
                    </div>

                    <label class="a-label">
                        <span style="font-size:11.5px">Title</span>
                        <input class="a-input a-input--sm" type="text" value="{{ $item->title }}" data-autosave-url="{{ $url }}" data-field="title" style="font-weight:600">
                    </label>

                    <label class="a-label">
                        <span style="font-size:11.5px">Excerpt</span>
                        <textarea class="a-input a-input--sm" rows="2" data-autosave-url="{{ $url }}" data-field="excerpt">{{ $item->excerpt }}</textarea>
                    </label>
                </div>
            </div>
        @endforeach

        <form method="POST" action="{{ route('admin.collection.store', 'blog') }}">
            @csrf
            <button type="submit" class="a-btn">+ Add article</button>
        </form>
    </div>
@endsection
