<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VKAAgroproducts Exports — Premium Coco Peat, Grow Bags & Husk Chips')</title>
    <meta name="description" content="@yield('description', 'Premium coco peat blocks, briquettes, grow bags and husk chips. Buffered, low-EC and batch-tested — manufactured in Pollachi, Tamil Nadu and exported to 40+ countries.')">

    {{-- Generated from the palm/coconut emblem in the logo. favicon.ico carries
         16/32/48 for browsers that ask for it by convention; the PNG links win
         where they are understood. The version query matters more here than
         elsewhere — browsers cache favicons far more stubbornly than assets. --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ $assetVersion }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v={{ $assetVersion }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}?v={{ $assetVersion }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v={{ $assetVersion }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}?v={{ $assetVersion }}">
    <meta name="theme-color" content="#123C2D">

    {{-- The loader's mark is the very first thing a visitor sees, so it goes
         out ahead of everything else. The nav logo follows at normal priority:
         wanted early for the largest paint, but not at the stylesheet's
         expense. --}}
    @foreach (['mark-palm', 'mark-swoosh', 'mark-ring', 'mark-drop'] as $layer)
        <link rel="preload" as="image" href="{{ asset($layer . '.png') }}?v={{ $assetVersion }}" fetchpriority="high">
    @endforeach

    @if ($logoUrl = \App\Models\Medium::url('logo'))
        <link rel="preload" as="image" href="{{ $logoUrl }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Fraunces for display, Inter for everything else. Both are variable and
         carry an optical-size axis, so the same file is drawn for a 76px
         headline and a 12px label rather than one compromise between them. --}}
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ $assetVersion }}">
    @stack('head')
</head>
<body>
    {{-- First thing in the body so it paints before anything below it. --}}
    @include('site.partials.loader')

    @yield('body')

    <script src="{{ asset('js/site.js') }}?v={{ $assetVersion }}" defer></script>
    @stack('scripts')
</body>
</html>
