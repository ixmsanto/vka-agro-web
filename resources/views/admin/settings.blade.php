@php
    $meta = [
        'hero' => ['crumb' => 'Home page', 'heading' => 'Hero section'],
        'video' => ['crumb' => 'Home page', 'heading' => 'Facility video'],
        'contact' => ['crumb' => 'Site-wide', 'heading' => 'Contact details'],
    ][$group];

    $fields = [
        'hero' => [
            ['badge', 'Badge', 'input'],
            ['titleLine1', 'Headline line 1', 'input'],
            ['titleAccent', 'Highlighted word(s)', 'accent'],
            ['titleLine3', 'Headline line 3', 'input'],
            ['subtitle', 'Subtitle', 'textarea'],
        ],
        'video' => [
            ['badge', 'Badge', 'input'],
            ['headingPre', 'Heading (start)', 'input'],
            ['headingAccent', 'Highlighted word(s)', 'accent'],
            ['subtitle', 'Subtitle', 'textarea'],
            ['caption', 'Caption chip', 'input'],
        ],
        'contact' => [
            ['address', 'Export office address', 'textarea'],
            ['email', 'Email', 'input'],
            ['phone', 'Phone · WhatsApp', 'input'],
            ['intro', 'Contact intro paragraph', 'textarea'],
        ],
    ][$group];

    $url = route('admin.settings.update', $group);
@endphp

@extends('layouts.admin', ['section' => $group])

@section('title', $meta['heading'])
@section('crumb', $meta['crumb'])
@section('heading', $meta['heading'])

@section('content')
    <div class="a-card" style="border-radius:20px;padding:clamp(22px,3vw,32px);display:flex;flex-direction:column;gap:18px;max-width:720px">
        @foreach ($fields as [$name, $label, $type])
            <label class="a-label">
                <span>{{ $label }}</span>
                @if ($type === 'textarea')
                    <textarea class="a-input" rows="3" data-autosave-url="{{ $url }}" data-save-method="PUT" data-save-style="named" data-field="{{ $name }}">{{ $values[$name] ?? '' }}</textarea>
                @else
                    <input class="a-input {{ $type === 'accent' ? 'a-input--accent' : '' }}" type="text" value="{{ $values[$name] ?? '' }}" data-autosave-url="{{ $url }}" data-save-method="PUT" data-save-style="named" data-field="{{ $name }}">
                @endif
            </label>
        @endforeach

        @if ($group === 'video')
            <p style="font-size:12.5px;color:#9AA69E;margin:0">The video file and its poster image are uploaded under <a href="{{ route('admin.media.index') }}">Images &amp; video</a>.</p>
        @endif

        @if ($group === 'contact')
            <p style="font-size:12.5px;color:#9AA69E;margin:0">These values drive the contact section, the top bar, the footer and every WhatsApp / phone link on the site.</p>
        @endif
    </div>
@endsection
