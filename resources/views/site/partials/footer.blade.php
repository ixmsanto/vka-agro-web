@php
    $explore = ['#about' => 'About us', '#gallery' => 'Gallery', '#video' => 'Facility tour', '#blog' => 'Insights & guides', '#contact' => 'Contact'];
    $productLinks = ['#products' => ['Coco peat 5 Kg blocks', 'Coco coir briquettes', 'Coco coir grow bags', 'Coco husk chips'], '#contact' => ['Custom blends']];
@endphp

<footer style="margin:0 clamp(12px,2vw,28px) clamp(12px,2vw,28px);background:linear-gradient(160deg, rgba(33,80,60,0.94), rgba(23,60,44,0.96));border:1px solid rgba(255,255,255,0.12);border-radius:26px;padding:clamp(34px,4vw,52px) 0 26px;backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);box-shadow:0 24px 60px rgba(33,80,60,0.22);position:relative;overflow:hidden">
    {{-- Light marks rather than green ones: the panel behind these is dark, and
         overflow:hidden keeps them inside its rounded corners. --}}
    <x-deco shape="husk" size="120" color="#FFFFFF" opacity="0.09" pos="top:-26px;right:-22px" motion="spin" wide />
    <x-deco shape="leaf" size="44" color="#63BE46" opacity="0.34" pos="bottom:32%;right:15%" motion="drift" delay="1.4s" rotate="24" wide />
    <x-deco shape="dots" size="46" color="#FFFFFF" opacity="0.12" pos="bottom:-8px;left:2%" motion="float-slow" delay="2.2s" wide />
    <x-deco shape="sparkle" size="16" color="#63BE46" opacity="0.46" pos="top:9%;left:47%" motion="float" delay="0.7s" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 var(--gutter);position:relative;z-index:1">
        <div data-fgrid style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1.3fr;gap:clamp(28px,4vw,64px);align-items:start">

            <div>
                <div style="font-family:var(--font-display);font-weight:600;font-size:var(--fs-stat);color:#FFFFFF">VKA<span style="font-style:italic;color:#63BE46">Agroproducts</span></div>
                <p style="font-size:var(--fs-sm);line-height:var(--lh-body);color:rgba(255,255,255,0.62);margin:var(--sp-3) 0 0;max-width:34ch">Premium coco peat, grow bags and husk chips — manufactured in Pollachi and exported to 40+ countries.</p>
                <div style="display:flex;gap:var(--sp-2);margin-top:var(--sp-5)">
                    <a href="#" aria-label="LinkedIn" class="vka-social" style="width:40px;height:40px;border-radius:11px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:#FFFFFF;display:inline-flex;align-items:center;justify-content:center;transition:background .3s ease, transform .3s ease, color .3s ease"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5A2.5 2.5 0 1 1 5 8.5a2.5 2.5 0 0 1-.02-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.4c0-1.3-.02-2.96-1.8-2.96-1.8 0-2.08 1.4-2.08 2.86V21H9z"/></svg></a>
                    <a href="#" aria-label="Instagram" class="vka-social" style="width:40px;height:40px;border-radius:11px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:#FFFFFF;display:inline-flex;align-items:center;justify-content:center;transition:background .3s ease, transform .3s ease, color .3s ease"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                    <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" aria-label="WhatsApp" class="vka-social-wa" style="width:40px;height:40px;border-radius:11px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:#FFFFFF;display:inline-flex;align-items:center;justify-content:center;transition:background .3s ease, transform .3s ease, color .3s ease"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.15-1.7-.84-2-.94-.26-.1-.46-.15-.65.15-.2.3-.75.94-.92 1.13-.17.2-.34.22-.63.08-.3-.15-1.24-.46-2.36-1.46-.87-.78-1.46-1.73-1.63-2.03-.17-.3-.02-.46.13-.6.13-.14.3-.34.44-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.65-1.58-.9-2.16-.24-.57-.48-.5-.65-.5l-.56-.01c-.2 0-.5.07-.77.37-.26.3-1 1-1 2.42s1.03 2.8 1.17 3c.15.2 2.02 3.08 4.9 4.32.68.3 1.22.47 1.63.6.69.22 1.31.19 1.8.11.55-.08 1.7-.69 1.94-1.36.24-.67.24-1.24.17-1.36-.07-.12-.26-.2-.56-.34zM12 2a10 10 0 0 0-8.6 15.06L2 22l5.06-1.33A10 10 0 1 0 12 2z"/></svg></a>
                </div>
            </div>

            <div>
                <div style="font-size:var(--fs-eyebrow);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;font-weight:700;color:rgba(255,255,255,0.5)">Explore</div>
                <div style="display:flex;flex-direction:column;gap:var(--sp-3);margin-top:var(--sp-4)">
                    @foreach ($explore as $href => $label)
                        <a href="{{ $href }}" class="vka-link-muted" style="font-size:var(--fs-sm);color:rgba(255,255,255,0.78)">{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            <div>
                <div style="font-size:var(--fs-eyebrow);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;font-weight:700;color:rgba(255,255,255,0.5)">Products</div>
                <div style="display:flex;flex-direction:column;gap:var(--sp-3);margin-top:var(--sp-4)">
                    @foreach ($productLinks as $href => $labels)
                        @foreach ($labels as $label)
                            <a href="{{ $href }}" class="vka-link-muted" style="font-size:var(--fs-sm);color:rgba(255,255,255,0.78)">{{ $label }}</a>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div>
                <div style="font-size:var(--fs-eyebrow);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;font-weight:700;color:rgba(255,255,255,0.5)">Export desk</div>
                <div style="display:flex;flex-direction:column;gap:var(--sp-3);margin-top:var(--sp-4)">
                    <div style="display:flex;gap:var(--sp-2);align-items:flex-start">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#63BE46" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex:0 0 auto;margin-top:var(--sp-1)" aria-hidden="true"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span style="font-size:var(--fs-sm);line-height:var(--lh-body);color:rgba(255,255,255,0.78)">{{ $contact['address'] }}</span>
                    </div>
                    <a href="mailto:{{ $contact['email'] }}" class="vka-link-muted" style="display:flex;gap:var(--sp-2);align-items:center;font-size:var(--fs-sm);color:#FFFFFF"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#63BE46" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex:0 0 auto" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></svg>{{ $contact['email'] }}</a>
                    <a href="tel:{{ $contact['phoneHref'] }}" class="vka-link-muted" style="display:flex;gap:var(--sp-2);align-items:center;font-size:var(--fs-sm);color:#FFFFFF"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#63BE46" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex:0 0 auto" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.8a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>{{ $contact['phone'] }}</a>
                    <div style="display:flex;flex-wrap:wrap;gap:var(--sp-1);margin-top:var(--sp-1)">
                        <span style="font-size:var(--fs-eyebrow);font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);border-radius:999px;padding:5px 11px">ISO 9001:2015</span>
                        <span style="font-size:var(--fs-eyebrow);font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);border-radius:999px;padding:5px 11px">IEC Registered</span>
                    </div>
                </div>
            </div>

        </div>

        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:var(--sp-3);margin-top:clamp(26px,3vw,36px);padding-top:20px;border-top:1px solid rgba(255,255,255,0.14)">
            <div style="font-size:var(--fs-xs);color:rgba(255,255,255,0.5)">© {{ date('Y') }} VKAAgroproducts Exports · Made in Tamil Nadu, India</div>
            <div style="display:flex;flex-wrap:wrap;gap:var(--sp-4)">
                <a href="#" class="vka-link-muted" style="font-size:var(--fs-xs);color:rgba(255,255,255,0.5)">Privacy Policy</a>
                <a href="#" class="vka-link-muted" style="font-size:var(--fs-xs);color:rgba(255,255,255,0.5)">Terms of Trade</a>
                <a href="{{ route('admin.dashboard') }}" class="vka-link-muted" style="font-size:var(--fs-xs);color:rgba(255,255,255,0.5)">Admin</a>
            </div>
        </div>
    </div>
</footer>

{{-- floating actions --}}
<div style="position:fixed;right:clamp(16px,2vw,26px);bottom:clamp(16px,2vw,26px);z-index:95;display:flex;flex-direction:column;align-items:flex-end;gap:var(--sp-3)">
    <button id="vka-top" type="button" aria-label="Back to top" class="vka-top-btn" style="width:52px;height:52px;padding:0;border:1px solid #E1EFDD;border-radius:50%;background:rgba(255,255,255,0.92);color:#2F8B3C;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 10px 28px rgba(33,80,60,0.18);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);opacity:0;transform:translateY(16px) scale(0.8);pointer-events:none;transition:opacity .45s cubic-bezier(.16,1,.3,1), transform .45s cubic-bezier(.16,1,.3,1), background .3s ease, color .3s ease">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
    </button>

    <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" class="vka-float-slow vka-wa-btn" style="position:relative;width:60px;height:60px;border-radius:50%;background:#25D366;color:#FFFFFF;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 14px 34px rgba(37,211,102,0.42)">
        <span class="vka-wa-ring" style="position:absolute;inset:0;border-radius:50%;border:2px solid #25D366;pointer-events:none"></span>
        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.15-1.7-.84-2-.94-.26-.1-.46-.15-.65.15-.2.3-.75.94-.92 1.13-.17.2-.34.22-.63.08-.3-.15-1.24-.46-2.36-1.46-.87-.78-1.46-1.73-1.63-2.03-.17-.3-.02-.46.13-.6.13-.14.3-.34.44-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.65-1.58-.9-2.16-.24-.57-.48-.5-.65-.5l-.56-.01c-.2 0-.5.07-.77.37-.26.3-1 1-1 2.42s1.03 2.8 1.17 3c.15.2 2.02 3.08 4.9 4.32.68.3 1.22.47 1.63.6.69.22 1.31.19 1.8.11.55-.08 1.7-.69 1.94-1.36.24-.67.24-1.24.17-1.36-.07-.12-.26-.2-.56-.34zM12 2a10 10 0 0 0-8.6 15.06L2 22l5.06-1.33A10 10 0 1 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.18-1.14l-.3-.18-3 .79.8-2.92-.2-.31A8.2 8.2 0 1 1 12 20.2z"/></svg>
    </a>
</div>
