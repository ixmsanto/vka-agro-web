@php
    $nav = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['key' => 'hero', 'label' => 'Hero section', 'url' => route('admin.settings.edit', 'hero')],
        ['key' => 'products', 'label' => 'Products', 'url' => route('admin.collection.index', 'products')],
        ['key' => 'blog', 'label' => 'Blog & insights', 'url' => route('admin.collection.index', 'blog')],
        ['key' => 'gallery', 'label' => 'Gallery', 'url' => route('admin.collection.index', 'gallery')],
        ['key' => 'testimonials', 'label' => 'Testimonials', 'url' => route('admin.collection.index', 'testimonials')],
        ['key' => 'video', 'label' => 'Facility video', 'url' => route('admin.settings.edit', 'video')],
        ['key' => 'media', 'label' => 'Images & video', 'url' => route('admin.media.index')],
        ['key' => 'contact', 'label' => 'Contact details', 'url' => route('admin.settings.edit', 'contact')],
        ['key' => 'inquiries', 'label' => 'Inquiries', 'url' => route('admin.inquiries.index')],
    ];

    $icons = [
        'dashboard' => '<rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/>',
        'hero' => '<path d="M4 5h16"/><path d="M4 12h10"/><path d="M4 19h7"/>',
        'products' => '<path d="M3 8l9-5 9 5-9 5-9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
        'blog' => '<path d="M4 4h11l5 5v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/><path d="M14 4v5h5"/><path d="M8 13h8"/><path d="M8 17h5"/>',
        'gallery' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/>',
        'testimonials' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/>',
        'video' => '<path d="M23 7l-7 5 7 5V7Z"/><rect x="1" y="5" width="15" height="14" rx="2"/>',
        'media' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>',
        'contact' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.8a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
        'inquiries' => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/>',
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · VKAAgroproducts</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ $assetVersion }}">
</head>
<body>
<div style="display:flex;min-height:100vh;align-items:stretch">

    <aside style="flex:0 0 auto;width:clamp(72px,20vw,248px);background:linear-gradient(180deg,#21503C,#123C2D);color:#fff;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;box-sizing:border-box;padding:22px 14px;overflow-y:auto">
        <div style="display:flex;align-items:center;gap:10px;padding:6px 8px 20px">
            <div style="font-family:'Newsreader',serif;font-size:24px;line-height:1;white-space:nowrap">VKA<span style="font-style:italic;color:#63BE46">Agroproducts</span></div>
        </div>
        <div class="a-sidebar-label" style="font-size:10.5px;letter-spacing:0.16em;text-transform:uppercase;color:rgba(255,255,255,0.4);padding:0 10px 8px">Manage</div>

        <nav style="display:flex;flex-direction:column;gap:3px">
            @foreach ($nav as $item)
                <a href="{{ $item['url'] }}" class="a-nav-btn {{ ($section ?? '') === $item['key'] ? 'is-active' : '' }}">
                    <span style="flex:0 0 auto;width:18px;display:inline-flex;color:inherit"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$item['key']] !!}</svg></span>
                    <span class="a-sidebar-label" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px;padding-top:16px">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;padding:10px 12px;border-radius:12px;border:1px solid rgba(255,255,255,0.14)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                <span class="a-sidebar-label" style="white-space:nowrap">View site</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;width:100%;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;padding:10px 12px;border-radius:12px;border:1px solid rgba(255,255,255,0.14);background:transparent;cursor:pointer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                    <span class="a-sidebar-label" style="white-space:nowrap">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <main style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column">
        <header style="position:sticky;top:0;z-index:20;background:rgba(238,244,234,0.85);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid #DDE7D8;padding:16px clamp(18px,3vw,40px);display:flex;align-items:center;justify-content:space-between;gap:16px">
            <div>
                <div style="font-size:11.5px;letter-spacing:0.12em;text-transform:uppercase;font-weight:700;color:#8A968E">@yield('crumb', 'Overview')</div>
                <h1 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(24px,2.6vw,32px);line-height:1.1;margin:3px 0 0;color:#21503C">@yield('heading', 'Dashboard')</h1>
            </div>
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:38px;height:38px;border-radius:50%;background:#2F8B3C;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div style="line-height:1.2">
                    <div style="font-size:13.5px;font-weight:700;color:#21503C">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size:11.5px;color:#8A968E">VKAAgroproducts</div>
                </div>
            </div>
        </header>

        <div style="padding:clamp(20px,3vw,40px);max-width:1080px;width:100%;box-sizing:border-box">
            @if ($errors->any())
                <div role="alert" style="margin-bottom:20px;background:rgba(214,80,60,0.1);border:1px solid rgba(214,80,60,0.35);border-radius:12px;padding:14px 18px;font-size:13.5px;font-weight:600;color:#B23B2A;display:flex;flex-direction:column;gap:4px">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<span id="a-flash" data-message="{{ session('status') }}" hidden></span>
<div id="a-toast" role="status" aria-live="polite"></div>

<script src="{{ asset('js/admin.js') }}?v={{ $assetVersion }}" defer></script>
</body>
</html>
