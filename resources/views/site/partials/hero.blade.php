@php
    $badges = ['100% Organic', 'Export Quality', 'Low EC < 0.5', 'Global Shipping'];

    $slides = [
        ['slot' => 'hero-slide-1', 'placeholder' => 'Transparent PNG product scene 1 — coco peat grow bag, blocks, loose coco peat, half coconut, palm leaves'],
        ['slot' => 'hero-slide-2', 'placeholder' => 'Transparent PNG product scene 2 — 5KG coco peat block close-up'],
        ['slot' => 'hero-slide-3', 'placeholder' => 'Transparent PNG product scene 3 — grow bags / briquettes'],
    ];

    $features = [
        ['Expands 7–8×', 'One block yields 70–75 L', '<path d="M12 22V11"/><path d="M12 12C12 8 9 6 4 6c0 4 3 6 8 6Z"/><path d="M12 11c0-3.5 3-5.5 8-5.5 0 3.5-3 5.5-8 5.5Z"/>'],
        ['Water Retention', 'Holds moisture for days', '<path d="M12 3s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11Z"/>'],
        ['Strong Roots', 'Aerated, healthy growth', '<path d="M12 21v-8"/><path d="M12 13c-3 0-4-2-4-5 3 0 4 2 4 5Z"/><path d="M12 13c3 0 4-2 4-5-3 0-4 2-4 5Z"/><path d="M9 21c1-2 5-2 6 0"/>'],
        ['Eco Friendly', '100% renewable coir', '<path d="M7 19a4 4 0 0 1-3.5-6l3-5.2M17 19H7M17 19a4 4 0 0 0 3.5-6l-3-5.2a4 4 0 0 0-7 0M6.5 12H3.5M17.5 12h3M12 4.6l1.5 2.6"/>'],
    ];
@endphp

<section id="hero" style="position:relative;background:radial-gradient(1200px 800px at 88% -10%, rgba(99,190,70,0.14), transparent 55%), radial-gradient(900px 700px at 6% 4%, rgba(255,255,255,0.9), transparent 60%), #FCFBF7;padding-bottom:clamp(96px,10vw,150px);box-sizing:border-box;overflow:visible">
    {{-- The hero already carries a lot, so it gets the lightest scattering. --}}
    <x-deco shape="sparkle" size="16" pos="top:20%;left:3%" opacity="0.42" motion="float" wide />
    <x-deco shape="dots" size="38" pos="bottom:22%;left:2%" opacity="0.23" motion="drift" delay="1.8s" wide />

    <div style="max-width:1460px;margin:0 auto;position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;gap:clamp(24px,2.6vw,48px);min-height:min(660px,86vh);padding:clamp(18px,2.6vw,40px) clamp(24px,5vw,68px) 0">

        <div style="flex:1 1 400px;display:flex;flex-direction:column;justify-content:center;box-sizing:border-box;z-index:2">
            <div data-reveal="1" style="display:inline-flex;align-self:flex-start;align-items:center;gap:var(--sp-2);background:rgba(255,255,255,0.85);border:1px solid #E1EFDD;border-radius:999px;padding:9px 17px 9px 12px;font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:#2F8B3C;box-shadow:0 6px 20px rgba(33,80,60,0.07);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)">
                <span class="vka-pulse-dot" style="width:9px;height:9px;border-radius:50%;background:#63BE46;flex:0 0 auto"></span>
                {{ $hero['badge'] }}
            </div>

            {{-- data-split, not data-reveal: site.js wraps each word in its own
                 clipping window so the line assembles itself. --}}
            <h1 data-split="2" style="font-family:var(--font-display);font-weight:500;font-size:var(--fs-display);line-height:var(--lh-display);letter-spacing:var(--ls-display);margin:var(--sp-4) 0 0;color:#123C2D">
                {{ $hero['titleLine1'] }}<br>
                <span style="font-style:italic;color:#63BE46">{{ $hero['titleAccent'] }}</span><br>
                {{ $hero['titleLine3'] }}
            </h1>

            <p data-reveal="3" style="font-size:var(--fs-lead);line-height:var(--lh-body);color:#5E6862;max-width:500px;margin:var(--sp-4) 0 0">{{ $hero['subtitle'] }}</p>

            <div data-reveal="4" style="display:flex;flex-wrap:wrap;align-items:center;gap:var(--sp-3);margin-top:var(--sp-5)">
                <a href="#contact" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:var(--sp-3);background:#2F8B3C;color:#FFFFFF;padding:18px 34px;border-radius:999px;font-size:var(--fs-body);font-weight:600;box-shadow:0 14px 34px rgba(47,139,60,0.32)">Request a Quote <span aria-hidden="true" style="display:inline-flex;width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,0.2);align-items:center;justify-content:center">→</span></a>
                <a href="#products" class="vka-btn-ghost" style="display:inline-flex;align-items:center;gap:var(--sp-2);background:rgba(255,255,255,0.7);border:1.5px solid #CFE3CC;color:#2F8B3C;padding:16px 28px;border-radius:999px;font-size:var(--fs-body);font-weight:600">Explore Products <span aria-hidden="true">→</span></a>
            </div>

            <div data-reveal="5" style="display:flex;flex-wrap:wrap;gap:var(--sp-2);margin-top:var(--sp-5)">
                @foreach ($badges as $badge)
                    <span style="display:inline-flex;align-items:center;gap:var(--sp-2);font-size:var(--fs-sm);font-weight:600;color:#21503C;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:9px 16px 9px 12px;box-shadow:0 4px 14px rgba(33,80,60,0.06);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)"><span style="width:18px;height:18px;border-radius:50%;background:#63BE46;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></span>{{ $badge }}</span>
                @endforeach
            </div>
        </div>

        {{-- The floor used to be 520px, which on a phone reserved ~130px of empty
             space below a slideshow only ~390px tall. --}}
        <div style="flex:1.42 1 560px;position:relative;align-self:stretch;display:flex;align-items:center;justify-content:center;min-height:clamp(340px,44vw,620px);z-index:1">

            {{-- soft golden core + green halo behind the product --}}
            <div style="position:absolute;width:94%;height:90%;right:1%;top:5%;background:radial-gradient(closest-side at 55% 46%, rgba(255,210,128,0.5), rgba(255,210,128,0.2) 36%, rgba(99,190,70,0.16) 60%, transparent 78%);filter:blur(28px);z-index:0;pointer-events:none"></div>
            <div style="position:absolute;width:58%;height:52%;right:9%;bottom:3%;background:radial-gradient(closest-side, rgba(99,190,70,0.24), transparent 72%);filter:blur(34px);z-index:0;pointer-events:none"></div>

            {{-- The stage is exactly the picture's box, and everything that floats
                 around the product hangs off it rather than off the column.

                 The column is up to 130px wider than the picture — it takes the
                 row's spare width, the picture is capped at 545px and centred in
                 it — so anything pinned to the column's edge landed that far
                 clear of the image. That is what stranded the seal out in the
                 page background beside the photo.

                 At 1080/1350 the height is 1.25x the width, so this cap is also
                 what sets the hero's height: 660px wide would mean 825px tall. --}}
            <div style="position:relative;width:100%;max-width:545px;aspect-ratio:1080 / 1350;z-index:2">

                {{-- The rounded frame is on the floating layer, not on this one:
                     the drop-shadow needs to read the rounded alpha, and clipping
                     on the outer box would crop the float's own travel instead of
                     riding along with it. --}}
                <div data-reveal="2" data-parallax data-depth="0.5" style="position:absolute;inset:0;filter:drop-shadow(0 48px 46px rgba(33,80,60,0.26)) drop-shadow(0 14px 22px rgba(33,80,60,0.14))">
                    <div class="vka-float" style="position:absolute;inset:0;border-radius:clamp(18px,2.2vw,30px);overflow:hidden">
                        @foreach ($slides as $i => $slide)
                            <div data-slide="{{ $i }}" style="position:absolute;inset:0;opacity:{{ $i === 0 ? 1 : 0 }};transition:opacity 1s cubic-bezier(.4,0,.2,1)">
                                <x-img-slot :src="\App\Models\Medium::url($slide['slot'])" :placeholder="$slide['placeholder']" fit="contain" />
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Inside the frame now, so the dots need a surface of their own
                     to stay legible over whatever photograph sits behind them. --}}
                <div style="position:absolute;bottom:clamp(12px,1.6vw,20px);left:50%;transform:translateX(-50%);display:flex;align-items:center;gap:var(--sp-2);z-index:5;background:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.7);border-radius:999px;padding:8px 13px;box-shadow:0 8px 24px rgba(33,80,60,0.16);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    @foreach ($slides as $i => $slide)
                        <button type="button" data-dot="{{ $i }}" aria-label="Slide {{ $i + 1 }}" style="width:{{ $i === 0 ? 26 : 9 }}px;height:9px;padding:0;border:none;border-radius:999px;background:{{ $i === 0 ? '#2F8B3C' : 'rgba(33,80,60,0.25)' }};cursor:pointer;transition:width .4s ease, background .4s ease"></button>
                    @endforeach
                </div>

                {{-- Rotating organic seal, straddling the frame's top-right
                     corner. The negative offset is measured from the picture, so
                     it overlaps the edge by a fixed amount however wide the
                     column around it happens to be. --}}
                <div data-hero-seal data-reveal="3" data-parallax data-depth="1.7" style="border-radius:50%;box-shadow:0 0 0 8px rgba(252,251,247,0.4), 0 18px 38px rgba(33,80,60,0.24)">
                <svg width="112" height="112" viewBox="0 0 112 112" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    {{-- Both legends ride the same r=42 arc, so they sweep equal angles
                         (163.2° vs 163.4°) and the separator dots land centred in the
                         gaps. They also share one 42.2–48.4 band: the top text grows
                         outward from its baseline, the bottom text is pushed out by dy
                         so it grows inward to meet it. The wider letter-spacing on the
                         bottom offsets its larger effective radius. --}}
                    <defs>
                        <path id="seal-top" d="M14,56 a42,42 0 1 1 84,0"/>
                        <path id="seal-bot" d="M14,56 a42,42 0 0 0 84,0"/>
                    </defs>
                    <circle cx="56" cy="56" r="55" fill="#2F8B3C"/>
                    <g class="vka-spin">
                        <text font-family="Inter, sans-serif" font-size="8.5" font-weight="700" letter-spacing="2.6" fill="#FFFFFF"><textPath href="#seal-top" startOffset="50%" text-anchor="middle">NATURAL PRODUCT</textPath></text>
                        <text font-family="Inter, sans-serif" font-size="8.5" font-weight="700" letter-spacing="2.9" dy="6.2" fill="#FFFFFF"><textPath href="#seal-bot" startOffset="50%" text-anchor="middle">PREMIUM QUALITY</textPath></text>
                        <circle cx="10.7" cy="56" r="1.6" fill="#FFFFFF"/>
                        <circle cx="101.3" cy="56" r="1.6" fill="#FFFFFF"/>
                    </g>
                    {{-- y=64 sits the cap-height centre of the digits on the circle centre. --}}
                    <text x="56" y="64" text-anchor="middle" font-family="Inter, sans-serif" font-size="23" font-weight="800" letter-spacing="-0.5" fill="#FFFFFF">100%</text>
                </svg>
            </div>

                {{-- floating glass card: product spec --}}
                <div data-hero-spec data-reveal="4" data-parallax data-depth="2.4" style="background:rgba(255,255,255,0.82);border:1px solid rgba(255,255,255,0.8);border-radius:18px;padding:16px 18px;box-shadow:0 24px 52px rgba(33,80,60,0.2);backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);z-index:4">
                <div style="display:flex;align-items:center;gap:var(--sp-2)">
                    <span style="width:36px;height:36px;border-radius:10px;background:#EDF8EC;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto;color:#2F8B3C"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l9-5 9 5-9 5-9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg></span>
                    <span style="font-size:var(--fs-sm);font-weight:700;color:#123C2D;line-height:var(--lh-heading)">5KG Coco Peat<br>Block</span>
                </div>
                <div style="height:1px;background:rgba(33,80,60,0.1);margin:var(--sp-3) 0"></div>
                <div style="display:flex;flex-direction:column;gap:var(--sp-2)">
                    @foreach (['Expands to 75 Litres', 'Buffered', 'Low EC < 0.5'] as $point)
                        <span style="display:flex;align-items:center;gap:var(--sp-2);font-size:var(--fs-xs);font-weight:500;color:#2E4A3C"><span style="width:16px;height:16px;border-radius:50%;background:#63BE46;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></span>{{ $point }}</span>
                    @endforeach
                    </div>
                </div>

                {{-- floating glass card: export stats --}}
                <div data-hero-stats data-reveal="5" data-parallax data-depth="2.9" style="background:rgba(255,255,255,0.82);border:1px solid rgba(255,255,255,0.8);border-radius:18px;padding:16px 20px;box-shadow:0 24px 52px rgba(33,80,60,0.2);backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);z-index:4">
                <div style="display:flex;align-items:center;gap:var(--sp-4)">
                    <div><div data-count style="font-family:var(--font-display);font-size:var(--fs-stat);line-height:1;color:#2F8B3C">40+</div><div style="font-size:var(--fs-eyebrow);font-weight:600;letter-spacing:var(--ls-label);color:#7A857E;margin-top:var(--sp-1)">Countries</div></div>
                    <div style="width:1px;height:34px;background:rgba(33,80,60,0.12)"></div>
                    <div><div data-count style="font-family:var(--font-display);font-size:var(--fs-stat);line-height:1;color:#2F8B3C">50k+</div><div style="font-size:var(--fs-eyebrow);font-weight:600;letter-spacing:var(--ls-label);color:#7A857E;margin-top:var(--sp-1)">Tons exported</div></div>
                </div>
                <div style="display:inline-flex;align-items:center;gap:var(--sp-2);margin-top:var(--sp-3);background:#EDF8EC;border-radius:999px;padding:6px 12px;font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:#2F8B3C"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3Z"/><path d="M9 12l2 2 4-4"/></svg>Premium Export Quality</div>
                </div>

            </div>

        </div>
    </div>

    <div style="display:flex;flex-direction:column;align-items:center;gap:var(--sp-2);margin:clamp(14px,1.8vw,24px) auto 0">
        <span style="width:26px;height:42px;border-radius:14px;border:2px solid rgba(33,80,60,0.28);position:relative;display:inline-block">
            <span style="position:absolute;left:50%;top:8px;margin-left:-2.5px;width:5px;height:5px;border-radius:50%;background:#2F8B3C;animation:vkaScroll 1.9s ease-in-out infinite"></span>
        </span>
        <span style="font-size:var(--fs-eyebrow);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;font-weight:600;color:#8A968E">Scroll</span>
    </div>

    {{-- feature strip; JS measures its height and overlaps it into the video section --}}
    <div data-feat-wrap style="position:absolute;left:0;right:0;bottom:0;transform:translateY(46%);z-index:6;padding:0 var(--gutter);pointer-events:none">
        <div data-feat-grid style="max-width:1180px;margin:0 auto;background:#FFFFFF;border:1px solid #EEF3EC;border-radius:26px;box-shadow:0 30px 70px rgba(33,80,60,0.16);display:grid;grid-template-columns:repeat(4,1fr);overflow:hidden;pointer-events:auto">
            @foreach ($features as $i => [$title, $sub, $icon])
                <div data-feat data-reveal="{{ $i + 6 }}" style="display:flex;align-items:center;gap:var(--sp-3);padding:clamp(15px,1.7vw,23px) clamp(18px,1.7vw,26px);border-right:1px solid #EEF3EC">
                    <span style="width:44px;height:44px;flex:0 0 auto;border-radius:13px;background:#EDF8EC;display:inline-flex;align-items:center;justify-content:center;color:#2F8B3C"><svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg></span>
                    <div><div style="font-size:var(--fs-body);font-weight:700;color:#123C2D">{{ $title }}</div><div style="font-size:var(--fs-xs);color:#7A857E;margin-top:var(--sp-1)">{{ $sub }}</div></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
