<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VKA Agro Exports — Premium Coco Peat, Grow Bags & Husk Chips')</title>
    <meta name="description" content="@yield('description', 'Premium coco peat blocks, briquettes, grow bags and husk chips. Buffered, low-EC and batch-tested — manufactured in Pollachi, Tamil Nadu and exported to 40+ countries.')">

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
    @yield('body')

    <script src="{{ asset('js/site.js') }}?v={{ $assetVersion }}" defer></script>
    @stack('scripts')
</body>
</html>
