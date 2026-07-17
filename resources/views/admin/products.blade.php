@extends('layouts.admin', ['section' => 'products'])

@section('title', 'Products')
@section('crumb', $config['crumb'])
@section('heading', $config['title'])

@section('content')
    <div style="display:flex;flex-direction:column;gap:18px">
        @foreach ($items as $item)
            @php $url = route('admin.collection.update', ['products', $item->id]); @endphp

            <div class="a-card" style="display:flex;gap:20px;flex-wrap:wrap">
                <div style="flex:0 0 auto;width:160px">
                    <x-admin.slot
                        :src="\App\Support\MediaStore::url($item->image_path)"
                        :upload-url="route('admin.collection.image', ['products', $item->id])"
                        :clear-url="$item->image_path ? route('admin.collection.image.destroy', ['products', $item->id]) : null"
                        label="Product image"
                        style="aspect-ratio:5/4"
                    />
                    @include('admin.partials.row-controls')
                </div>

                <div style="flex:1 1 320px;min-width:0;display:flex;flex-direction:column;gap:12px">
                    <div style="display:grid;grid-template-columns:80px 1fr;gap:12px">
                        <label class="a-label">
                            <span style="font-size:11.5px">No.</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->num }}" data-autosave-url="{{ $url }}" data-field="num">
                        </label>
                        <label class="a-label">
                            <span style="font-size:11.5px">Category tag</span>
                            <input class="a-input a-input--sm" type="text" value="{{ $item->tag }}" data-autosave-url="{{ $url }}" data-field="tag">
                        </label>
                    </div>

                    <label class="a-label">
                        <span style="font-size:11.5px">Title</span>
                        <input class="a-input a-input--sm" type="text" value="{{ $item->title }}" data-autosave-url="{{ $url }}" data-field="title" style="font-weight:600">
                    </label>

                    <label class="a-label">
                        <span style="font-size:11.5px">Description</span>
                        <textarea class="a-input a-input--sm" rows="3" data-autosave-url="{{ $url }}" data-field="description">{{ $item->description }}</textarea>
                    </label>

                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                            <span style="font-size:11.5px;font-weight:600;color:#6A756E">Spec sheet</span>
                            <form method="POST" action="{{ route('admin.specs.store', $item->id) }}">
                                @csrf
                                <button type="submit" style="font-size:12px;font-weight:600;color:#2F8B3C;background:#EDF8EC;border:none;border-radius:8px;padding:5px 11px;cursor:pointer">+ Add spec</button>
                            </form>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:8px">
                            @foreach ($item->specs as $spec)
                                @php $specUrl = route('admin.specs.update', $spec->id); @endphp
                                <div style="display:grid;grid-template-columns:1fr 1fr 34px;gap:8px;align-items:center">
                                    <input class="a-input" type="text" value="{{ $spec->label }}" placeholder="Label" data-autosave-url="{{ $specUrl }}" data-field="label" style="padding:9px 11px;border-radius:8px;font-size:13px;color:#5E6862">
                                    <input class="a-input" type="text" value="{{ $spec->value }}" placeholder="Value" data-autosave-url="{{ $specUrl }}" data-field="value" style="padding:9px 11px;border-radius:8px;font-size:13px;font-weight:600">
                                    <form method="POST" action="{{ route('admin.specs.destroy', $spec->id) }}" data-confirm="Remove this spec?" style="display:flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="a-icon-btn a-icon-btn--danger" title="Remove spec" aria-label="Remove spec" style="padding:8px">✕</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <form method="POST" action="{{ route('admin.collection.store', 'products') }}">
            @csrf
            <button type="submit" class="a-btn">+ Add product</button>
        </form>
    </div>
@endsection
