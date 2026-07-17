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
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ $assetVersion }}">
    @stack('head')
</head>
<body>
    @yield('body')

    <script src="{{ asset('js/site.js') }}?v={{ $assetVersion }}" defer></script>
    @stack('scripts')
</body>
</html>
