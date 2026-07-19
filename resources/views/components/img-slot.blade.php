@props([
    'src' => null,
    'placeholder' => '',
    'fit' => 'cover',
    'alt' => null,
    'circle' => false,
    'size' => null,
])

{{-- fit="cover"/"contain" absolutely fill the parent, so the parent must be
     position:relative and carry its own height. fit="natural" instead lets the
     image's own proportions set the height, for layouts like the masonry
     gallery where the box follows the picture rather than the other way round.
     Falls back to a labelled placeholder until an admin uploads an image. --}}
@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $alt ?? $placeholder }}"
        loading="lazy"
        decoding="async"
        {{-- Reserves the right box before the bytes arrive, so a masonry
             column does not repack as images stream in. --}}
        @if ($size) width="{{ $size[0] }}" height="{{ $size[1] }}" @endif
        class="vka-img vka-img--{{ $fit }}"
        @style(['border-radius:50%' => $circle])
    >
@else
    <div @class(['vka-slot', 'vka-slot--natural' => $fit === 'natural']) @style(['border-radius:50%' => $circle]) role="img" aria-label="{{ $placeholder }}">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <circle cx="9" cy="9" r="2"/>
            <path d="m21 15-5-5L5 21"/>
        </svg>
        @unless ($circle)
            <span>{{ $placeholder }}</span>
        @endunless
    </div>
@endif
