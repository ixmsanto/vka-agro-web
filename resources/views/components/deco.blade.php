@props([
    'shape' => 'leaf',
    'size' => 34,
    'color' => '#63BE46',
    'opacity' => 0.16,
    'pos' => '',
    'motion' => null,
    'delay' => null,
    'wide' => false,
    'rotate' => null,
])

{{-- Small ornamental marks — leaves, seeds, rings, dot grids — scattered behind
     the sections to warm up the empty margins.

     Purely decorative: aria-hidden and pointer-events:none, so they are invisible
     to assistive tech and never intercept a click meant for the content above
     them. Position comes in through `pos` as a plain declaration string rather
     than through attribute merging, so a caller reads the same way as the inline
     styles everywhere else in this codebase.

     `wide` drops the mark below 860px, where the columns stack and the margins
     these live in disappear. --}}

@php
    // 24x24 viewBox throughout. Stroke shapes inherit the 1.7 weight the icons
    // elsewhere use; the two fill shapes declare it themselves.
    $shapes = [
        'leaf' => ['stroke', '<path d="M12 22V11"/><path d="M12 12C12 8 9 6 4 6c0 4 3 6 8 6Z"/><path d="M12 11c0-3.5 3-5.5 8-5.5 0 3.5-3 5.5-8 5.5Z"/>'],
        'sprout' => ['stroke', '<path d="M7 21h10"/><path d="M12 21v-9"/><path d="M12 12C12 8.5 9.5 6.5 6 6.5c0 3.5 2.5 5.5 6 5.5Z"/><path d="M12 12c0-3 2.5-5 6-5 0 3-2.5 5-6 5Z"/>'],
        'ring' => ['stroke', '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4.6"/>'],
        'arc' => ['stroke', '<path d="M2 22A20 20 0 0 1 22 2"/><path d="M2 22A13 13 0 0 1 15 9"/><path d="M2 22a6 6 0 0 1 6-6"/>'],
        'drop' => ['stroke', '<path d="M12 3s6.5 7 6.5 11.5a6.5 6.5 0 0 1-13 0C5.5 10 12 3 12 3Z"/>'],
        'wave' => ['stroke', '<path d="M2 9c3.3-4 6.7-4 10 0s6.7 4 10 0"/><path d="M2 16c3.3-4 6.7-4 10 0s6.7 4 10 0"/>'],
        'seed' => ['stroke', '<ellipse cx="12" cy="12" rx="5.5" ry="9" transform="rotate(32 12 12)"/><path d="M8.4 16.2 15.6 7.8"/>'],
        'husk' => ['stroke', '<circle cx="12" cy="12" r="9.5"/><path d="M12 2.5c3 4 3 15 0 19"/><path d="M12 2.5c-3 4-3 15 0 19"/>'],
        'sparkle' => ['fill', '<path d="M12 1.5c0 5.8 4.7 10.5 10.5 10.5C16.7 12 12 16.7 12 22.5 12 16.7 7.3 12 1.5 12 7.3 12 12 7.3 12 1.5Z"/>'],
        'dots' => ['fill', '<circle cx="4" cy="4" r="1.7"/><circle cx="12" cy="4" r="1.7"/><circle cx="20" cy="4" r="1.7"/><circle cx="4" cy="12" r="1.7"/><circle cx="12" cy="12" r="1.7"/><circle cx="20" cy="12" r="1.7"/><circle cx="4" cy="20" r="1.7"/><circle cx="12" cy="20" r="1.7"/><circle cx="20" cy="20" r="1.7"/>'],
    ];

    [$mode, $path] = $shapes[$shape] ?? $shapes['leaf'];

    $classes = 'vka-deco' . ($wide ? ' vka-deco--wide' : '');
    if ($motion) {
        $classes .= ' ' . match ($motion) {
            'float' => 'vka-float',
            'float-slow' => 'vka-float-slow',
            'spin' => 'vka-deco-spin',
            default => 'vka-deco-drift',
        };
    }

    $style = $pos
        . ';color:' . $color
        . ';opacity:' . $opacity
        . ($rotate ? ';rotate:' . $rotate . 'deg' : '')
        . ($delay ? ';animation-delay:' . $delay : '');
@endphp

<span aria-hidden="true" class="{{ $classes }}" style="{{ $style }}">
    @if ($mode === 'fill')
        <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="currentColor">{!! $path !!}</svg>
    @else
        <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">{!! $path !!}</svg>
    @endif
</span>
