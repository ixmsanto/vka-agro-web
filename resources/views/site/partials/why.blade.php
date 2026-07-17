@php
    $cards = [
        ['Batch-tested specs', 'Every lot is checked for EC and pH before dispatch, with a certificate to match.', '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'],
        ['Low EC &amp; buffered', 'Washed and calcium-buffered media so roots start in a stable, safe environment.', '<path d="M12 3s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11Z"/>'],
        ['40+ country logistics', 'FOB, CIF and CFR shipping with documentation handled end to end.', '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20Z"/>'],
        ['Custom blends', 'Pith-to-chip ratios, EC targets and private-label packing built to your spec.', '<path d="M3 8l9-5 9 5-9 5-9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>'],
        ['On-time loading', 'Predictable lead times and container loading you can plan a season around.', '<path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>'],
        ['Renewable by nature', 'A coconut byproduct given a second life — sustainable growing, nothing wasted.', '<path d="M7 19a4 4 0 0 1-3.5-6l3-5.2M17 19H7M17 19a4 4 0 0 0 3.5-6l-3-5.2a4 4 0 0 0-7 0M6.5 12H3.5M17.5 12h3M12 4.6l1.5 2.6"/>'],
    ];
@endphp

<section id="why" style="padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">
        <div style="text-align:center;max-width:660px;margin:0 auto clamp(40px,5vw,60px)">
            <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                Why VKA Agro
            </div>
            <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">A supplier your <span style="font-style:italic;color:#63BE46">agronomist</span> can trust.</h2>
            <p data-reveal="2" style="font-size:clamp(15px,1.1vw,17px);line-height:1.7;color:#5E6862;margin:16px auto 0;max-width:520px">Consistent chemistry, honest grading and logistics that actually arrive on time.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(300px,100%),1fr));gap:clamp(16px,2vw,24px)">
            @foreach ($cards as $i => [$title, $body, $icon])
                <div data-reveal="{{ $i + 3 }}" style="background:#FFFFFF;border:1px solid #EEF3EC;border-radius:22px;padding:30px 28px;box-shadow:0 16px 44px rgba(33,80,60,0.07)">
                    <span style="width:52px;height:52px;border-radius:15px;background:#EDF8EC;display:inline-flex;align-items:center;justify-content:center;color:#2F8B3C"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg></span>
                    <h3 style="font-size:18px;font-weight:700;color:#123C2D;margin:20px 0 0">{!! $title !!}</h3>
                    <p style="font-size:14.5px;line-height:1.65;color:#7A857E;margin:10px 0 0">{{ $body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
