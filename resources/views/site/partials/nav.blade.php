@php
    $links = [
        '#hero' => 'Home',
        '#about' => 'About',
        '#products' => 'Products',
        '#gallery' => 'Gallery',
        '#blog' => 'Blog',
        '#video' => 'Facility',
        '#contact' => 'Contact',
    ];
    $logo = \App\Models\Medium::url('logo');
@endphp

<nav id="vka-nav" style="position:fixed;top:0;left:0;right:0;z-index:100;background:transparent;border-bottom:1px solid transparent;backdrop-filter:blur(0px);-webkit-backdrop-filter:blur(0px);transition:background .45s ease, box-shadow .45s ease, border-color .45s ease, backdrop-filter .45s ease">

    <div id="vka-topbar" class="vka-desktop-block" style="background:#123C2D;color:rgba(255,255,255,0.82);overflow:hidden;transition:max-height .45s ease, opacity .35s ease;max-height:44px;opacity:1">
        <div style="max-width:1440px;margin:0 auto;padding:0 clamp(18px,3vw,44px);height:38px;display:flex;align-items:center;justify-content:space-between;gap:var(--sp-5)">
            <div style="display:flex;align-items:center;gap:var(--sp-5);font-size:var(--fs-xs);font-weight:500">
                <a href="mailto:{{ $contact['email'] }}" class="vka-link-muted" style="display:inline-flex;align-items:center;gap:var(--sp-2);color:rgba(255,255,255,0.82)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#63BE46" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></svg>{{ $contact['email'] }}
                </a>
                <span style="display:inline-flex;align-items:center;gap:var(--sp-2);color:rgba(255,255,255,0.62)"><span style="width:5px;height:5px;border-radius:50%;background:#63BE46"></span>Mon–Sat · 9:00–18:00 IST</span>
            </div>
            <div style="display:flex;align-items:center;gap:var(--sp-4)">
                <span style="font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:rgba(255,255,255,0.55)">ISO 9001:2015 · Exporting to 40+ countries</span>
                <span style="width:1px;height:16px;background:rgba(255,255,255,0.18)"></span>
                <div style="display:flex;align-items:center;gap:var(--sp-2)">
                    <a href="#" aria-label="LinkedIn" class="vka-link-muted" style="color:rgba(255,255,255,0.72)"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5A2.5 2.5 0 1 1 5 8.5a2.5 2.5 0 0 1-.02-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.4c0-1.3-.02-2.96-1.8-2.96-1.8 0-2.08 1.4-2.08 2.86V21H9z"/></svg></a>
                    <a href="#" aria-label="Instagram" class="vka-link-muted" style="color:rgba(255,255,255,0.72)"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                    <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" aria-label="WhatsApp" class="vka-link-muted" style="color:rgba(255,255,255,0.72)"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.15-1.7-.84-2-.94-.26-.1-.46-.15-.65.15-.2.3-.75.94-.92 1.13-.17.2-.34.22-.63.08-.3-.15-1.24-.46-2.36-1.46-.87-.78-1.46-1.73-1.63-2.03-.17-.3-.02-.46.13-.6.13-.14.3-.34.44-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.65-1.58-.9-2.16-.24-.57-.48-.5-.65-.5l-.56-.01c-.2 0-.5.07-.77.37-.26.3-1 1-1 2.42s1.03 2.8 1.17 3c.15.2 2.02 3.08 4.9 4.32.68.3 1.22.47 1.63.6.69.22 1.31.19 1.8.11.55-.08 1.7-.69 1.94-1.36.24-.67.24-1.24.17-1.36-.07-.12-.26-.2-.56-.34zM12 2a10 10 0 0 0-8.6 15.06L2 22l5.06-1.33A10 10 0 1 0 12 2z"/></svg></a>
                </div>
            </div>
        </div>
    </div>

    <div style="max-width:1440px;margin:0 auto;padding:0 clamp(18px,3vw,44px);height:clamp(66px,7vw,80px);display:flex;align-items:center;justify-content:space-between;gap:clamp(14px,2vw,32px)">
        <a href="#hero" aria-label="VKA Agro Products home" style="display:flex;align-items:center;flex:0 0 auto">
            @if ($logo)
                <img src="{{ $logo }}" alt="VKA Agro Products" style="height:clamp(42px,4.4vw,56px);width:auto;display:block">
            @else
                <span style="font-family:var(--font-display);font-weight:600;font-size:var(--fs-h3);line-height:1;color:#123C2D">VKA<span style="font-style:italic;color:#63BE46">&nbsp;Agro</span></span>
            @endif
        </a>

        {{-- The active link used to be hardcoded to the first one. site.js now
             works it out from the scroll position and slides a single shared
             underline between them, so every link is authored identically and
             the one below is only the no-JS default. --}}
        <div id="vka-navlinks" class="vka-desktop" style="align-items:center;gap:clamp(14px,1.8vw,30px);flex:1 1 auto;justify-content:center">
            @foreach ($links as $href => $label)
                <a href="{{ $href }}" data-navlink class="vka-nav-link" style="font-size:var(--fs-body);font-weight:{{ $loop->first ? 700 : 500 }};color:{{ $loop->first ? '#123C2D' : '#5E6862' }};padding:4px 2px 6px;transition:color .25s ease">{{ $label }}</a>
            @endforeach
        </div>

        <div class="vka-desktop" style="align-items:center;gap:clamp(12px,1.4vw,20px);flex:0 0 auto">
            <a href="tel:{{ $contact['phoneHref'] }}" class="vka-wide" style="align-items:center;gap:var(--sp-2)">
                <span style="flex:0 0 auto;width:38px;height:38px;border-radius:50%;background:#EDF8EC;display:inline-flex;align-items:center;justify-content:center"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2F8B3C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.8a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg></span>
                <span style="display:flex;flex-direction:column;line-height:var(--lh-heading)">
                    <span style="font-size:var(--fs-sm);font-weight:700;color:#123C2D">{{ $contact['phone'] }}</span>
                    <span style="font-size:var(--fs-eyebrow);color:#8A968E">Mon–Sat · 9–6</span>
                </span>
            </a>
            <a href="#contact" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:var(--sp-2);background:#2F8B3C;color:#FFFFFF;padding:12px 22px;border-radius:999px;font-size:var(--fs-sm);font-weight:600;white-space:nowrap;box-shadow:0 8px 22px rgba(47,139,60,0.22)">Get a Quote <span aria-hidden="true" style="display:inline-flex;width:21px;height:21px;border-radius:50%;background:rgba(255,255,255,0.2);align-items:center;justify-content:center">→</span></a>
        </div>

        <button id="vka-burger" class="vka-mobile" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="vka-drawer" style="flex:0 0 auto;background:rgba(255,255,255,0.85);border:1px solid #E1EFDD;border-radius:14px;width:46px;height:46px;padding:0;flex-direction:column;align-items:center;justify-content:center;gap:var(--sp-1);cursor:pointer;box-shadow:0 4px 14px rgba(33,80,60,0.08)">
            <span style="display:block;width:20px;height:2px;border-radius:2px;background:#123C2D"></span>
            <span style="display:block;width:20px;height:2px;border-radius:2px;background:#123C2D"></span>
            <span style="display:block;width:20px;height:2px;border-radius:2px;background:#123C2D"></span>
        </button>
    </div>
</nav>

<div id="vka-drawer" style="position:fixed;inset:0;z-index:99;background:rgba(250,253,248,0.98);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);padding:clamp(84px,16vw,110px) clamp(24px,7vw,52px) 40px;flex-direction:column">
    <div style="display:flex;flex-direction:column">
        @foreach ($links as $href => $label)
            <a href="{{ $href }}" style="font-family:var(--font-display);font-weight:500;font-size:var(--fs-h3);color:#123C2D;padding:var(--sp-3) 0;border-bottom:1px solid #E1EFDD">{{ $label }}</a>
        @endforeach
    </div>
    <a href="#contact" style="display:inline-flex;align-self:flex-start;align-items:center;gap:var(--sp-2);margin-top:clamp(24px,5vw,34px);background:#2F8B3C;color:#FFFFFF;padding:16px 30px;border-radius:999px;font-size:var(--fs-body);font-weight:600;box-shadow:0 14px 32px rgba(47,139,60,0.3)">Request a Quote <span aria-hidden="true">→</span></a>
    <a href="tel:{{ $contact['phoneHref'] }}" style="margin-top:var(--sp-5);font-size:var(--fs-body);font-weight:600;color:#5E6862">{{ $contact['phone'] }} · Mon–Sat 9–6</a>
</div>
