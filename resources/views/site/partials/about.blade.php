@php
    $points = [
        ['Consistent, tested specs', 'Low EC, buffered and batch-certified for every shipment.', '<path d="M20 6 9 17l-5-5"/>'],
        ['Reliable global logistics', 'FOB Tuticorin, CIF &amp; CFR to 40+ countries.', '<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Z"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20Z"/>'],
        ['100% renewable coir', 'A byproduct given a second life — nothing wasted.', '<path d="M12 22V11"/><path d="M12 12C12 8 9 6 4 6c0 4 3 6 8 6Z"/><path d="M12 11c0-3.5 3-5.5 8-5.5 0 3.5-3 5.5-8 5.5Z"/>'],
    ];

    $stats = [['40+', 'Countries served'], ['50k+', 'Tons exported'], ['ISO', '9001:2015 certified']];
@endphp

<section id="about" style="padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px);display:flex;flex-wrap:wrap;align-items:center;gap:clamp(40px,6vw,88px)">

        <div style="flex:1 1 min(420px,100%);position:relative;order:2">
            <div data-reveal="1" style="position:relative;aspect-ratio:4 / 5;border-radius:26px;overflow:hidden;background:rgba(99,190,70,0.12);box-shadow:0 34px 80px rgba(33,80,60,0.2)">
                <x-img-slot :src="\App\Models\Medium::url('about-photo')" placeholder="Facility / plantation photo (portrait 4:5) — team, coir processing or coconut grove" fit="cover" />
            </div>
            <div data-reveal="2" style="position:absolute;left:clamp(-8px,-1vw,0px);bottom:clamp(-18px,-2vw,-24px);background:#FFFFFF;border:1px solid #EEF3EC;border-radius:20px;padding:18px 22px;box-shadow:0 22px 50px rgba(33,80,60,0.16);display:flex;align-items:center;gap:16px">
                <div style="font-family:'Newsreader',serif;font-size:clamp(34px,4vw,46px);line-height:1;color:#2F8B3C">15+</div>
                <div style="font-size:13px;font-weight:600;line-height:1.35;color:#5E6862">Years crafting<br>export-grade coir</div>
            </div>
        </div>

        <div style="flex:1 1 min(440px,100%);order:1">
            <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                About VKA Agro
            </div>
            <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:20px 0 0;color:#123C2D">Rooted in Pollachi, <span style="font-style:italic;color:#63BE46">shipped worldwide.</span></h2>
            <p data-reveal="2" style="font-size:clamp(16px,1.1vw,17.5px);line-height:1.74;color:#5E6862;margin:22px 0 0;max-width:52ch">From the coconut belt of Tamil Nadu, VKA Agro turns raw coir into precision-buffered coco peat, grow bags and husk chips. Every batch is washed, aged and tested for EC and pH before it leaves our floor — so growers from Europe to the Gulf plant with confidence.</p>

            <div data-reveal="3" style="display:flex;flex-direction:column;gap:14px;margin-top:30px;max-width:520px">
                @foreach ($points as [$title, $sub, $icon])
                    <div style="display:flex;align-items:flex-start;gap:14px">
                        <span style="flex:0 0 auto;width:40px;height:40px;border-radius:12px;background:#EDF8EC;display:inline-flex;align-items:center;justify-content:center;color:#2F8B3C"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg></span>
                        <div><div style="font-size:15.5px;font-weight:700;color:#123C2D">{{ $title }}</div><div style="font-size:14px;color:#7A857E;margin-top:2px">{!! $sub !!}</div></div>
                    </div>
                @endforeach
            </div>

            <div data-reveal="4" style="display:flex;flex-wrap:wrap;gap:clamp(28px,4vw,52px);margin-top:36px;padding-top:30px;border-top:1px solid rgba(33,80,60,0.12)">
                @foreach ($stats as [$value, $label])
                    <div><div style="font-family:'Newsreader',serif;font-size:clamp(30px,3.6vw,44px);line-height:1;color:#2F8B3C">{{ $value }}</div><div style="font-size:13px;font-weight:600;letter-spacing:0.04em;color:#7A857E;margin-top:6px">{{ $label }}</div></div>
                @endforeach
            </div>
        </div>
    </div>
</section>
