@props([
    'src' => null,
    'uploadUrl',
    'clearUrl' => null,
    'field' => 'image',
    'accept' => 'image/*',
    'label' => 'Drop an image or click to browse',
    'video' => false,
])

{{-- Click or drag-and-drop to upload; the ✕ clears the slot. --}}
<div {{ $attributes->class(['a-slot'])->merge(['data-upload-url' => $uploadUrl, 'data-upload-field' => $field]) }}>
    @if ($src)
        @if ($video)
            <video src="{{ $src }}" muted playsinline preload="metadata"></video>
        @else
            <img src="{{ $src }}" alt="">
        @endif
    @else
        <div class="a-slot__empty">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
            <span>{{ $label }}</span>
        </div>
    @endif

    <input type="file" accept="{{ $accept }}" hidden>

    @if ($src && $clearUrl)
        <form method="POST" action="{{ $clearUrl }}" data-confirm="Remove this image?">
            @csrf
            @method('DELETE')
            <button type="submit" class="a-slot__clear" title="Remove" aria-label="Remove image">✕</button>
        </form>
    @endif
</div>
