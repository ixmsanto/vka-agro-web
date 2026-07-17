@extends('layouts.admin', ['section' => 'testimonials'])

@section('title', 'Testimonials')
@section('crumb', $config['crumb'])
@section('heading', $config['title'])

@section('content')
    <div style="display:flex;flex-direction:column;gap:18px">
        @foreach ($items as $item)
            @php $url = route('admin.collection.update', ['testimonials', $item->id]); @endphp

            <div class="a-card" style="display:flex;gap:20px;flex-wrap:wrap;align-items:flex-start">
                <div style="flex:0 0 auto;width:96px">
                    <x-admin.slot
                        :src="\App\Support\MediaStore::url($item->image_path)"
                        :upload-url="route('admin.collection.image', ['testimonials', $item->id])"
                        :clear-url="$item->image_path ? route('admin.collection.image.destroy', ['testimonials', $item->id]) : null"
                        label="Photo"
                        style="width:96px;height:96px;border-radius:50%"
                    />
                    @include('admin.partials.row-controls')
                </div>

                <div style="flex:1 1 320px;min-width:0;display:flex;flex-direction:column;gap:12px">
                    <label class="a-label">
                        <span style="font-size:11.5px">Quote</span>
                        <textarea class="a-input a-input--sm" rows="3" data-autosave-url="{{ $url }}" data-field="quote">{{ $item->quote }}</textarea>
                    </label>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <label class="a-label">
                            <span style="font-size:11.5px">Name</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->name }}" data-autosave-url="{{ $url }}" data-field="name" style="font-weight:600">
                        </label>
                        <label class="a-label">
                            <span style="font-size:11.5px">Role · Country</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->role }}" data-autosave-url="{{ $url }}" data-field="role">
                        </label>
                    </div>
                </div>
            </div>
        @endforeach

        <form method="POST" action="{{ route('admin.collection.store', 'testimonials') }}">
            @csrf
            <button type="submit" class="a-btn">+ Add testimonial</button>
        </form>
    </div>
@endsection
