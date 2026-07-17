@extends('layouts.admin', ['section' => 'media'])

@section('title', 'Images & video')
@section('crumb', 'Media')
@section('heading', 'Images & video')

@section('content')
    <p style="font-size:14px;line-height:1.7;color:#5E6862;margin:0 0 22px;max-width:64ch">Drop a file onto a slot, or click it to browse. Hero slides are shown as a rotating slideshow; the facility video plays behind the poster image.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(240px,100%),1fr));gap:16px">
        @foreach ($slots as $slot => $config)
            @php
                $path = $paths[$slot] ?? null;
                $isVideo = $config['accept'] === 'video';
            @endphp
            <div class="a-card" style="border-radius:16px;padding:14px">
                <x-admin.slot
                    :src="\App\Support\MediaStore::url($path)"
                    :upload-url="route('admin.media.store', $slot)"
                    :clear-url="$path ? route('admin.media.destroy', $slot) : null"
                    field="file"
                    :accept="$isVideo ? 'video/*' : 'image/*'"
                    :video="$isVideo"
                    :label="$isVideo ? 'Drop an MP4 or click to browse' : 'Drop an image or click to browse'"
                    style="aspect-ratio:4/3;border-radius:11px"
                />
                <div style="margin-top:12px;font-size:13.5px;font-weight:700;color:#21503C">{{ $config['label'] }}</div>
                <div style="font-size:11.5px;color:#9AA69E;margin-top:2px">{{ $path ? 'Uploaded' : 'Empty — placeholder shown on the site' }}</div>
            </div>
        @endforeach
    </div>
@endsection
