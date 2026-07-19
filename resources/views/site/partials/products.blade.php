@php
    // Rows shown before the visitor asks for more, and how many each press adds.
    $initialRows = 3;
    $moreStep = 3;
@endphp

<section id="products" style="position:relative;padding:clamp(44px,6vw,80px) 0;scroll-margin-top:80px">
    <x-deco shape="seed" size="30" pos="top:7%;right:4%" opacity="0.34" motion="drift" rotate="-12" wide />
    <x-deco shape="dots" size="42" pos="top:34%;left:2.5%" opacity="0.25" motion="float-slow" delay="1.4s" wide />
    <x-deco shape="husk" size="52" pos="bottom:26%;right:4.5%" opacity="0.23" motion="drift" delay="2.6s" wide />
    <x-deco shape="leaf" size="26" pos="bottom:30%;left:4.5%" opacity="0.34" motion="float" delay="0.9s" rotate="26" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px);position:relative;z-index:1">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px">
            <div style="max-width:600px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Our Products
                </div>
                <h2 data-split="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(30px,3.6vw,48px);line-height:1.06;letter-spacing:-0.015em;margin:14px 0 0;color:#123C2D">One raw material, <span style="font-style:italic;color:#63BE46">every format</span> you grow with.</h2>
            </div>
            <p data-reveal="2" style="font-size:clamp(15px,1.1vw,17px);line-height:1.7;color:#5E6862;max-width:38ch;margin:0">Blocks, briquettes, grow bags and husk chips — buffered, low-EC and pressed to export spec.</p>
        </div>

        <div style="display:flex;flex-direction:column;gap:clamp(32px,4vw,56px);margin-top:clamp(30px,3.5vw,52px)">
            @foreach ($products as $product)
                <div data-prow @if ($loop->index >= $initialRows) data-more-item="products" @endif style="align-items:center;gap:clamp(20px,3vw,48px)">
                    <div data-pimg data-reveal="3" data-fx="mask" style="position:relative;aspect-ratio:5 / 4;border-radius:20px;overflow:hidden;background:rgba(99,190,70,0.1);box-shadow:0 18px 44px rgba(33,80,60,0.12)">
                        <x-img-slot :src="\App\Support\MediaStore::url($product->image_path)" :placeholder="$product->image_placeholder" :alt="$product->title" fit="cover" />
                    </div>
                    <div data-reveal="4" data-fx="right">
                        <div style="display:flex;align-items:center;gap:12px">
                            <span style="font-family:'Newsreader',serif;font-size:22px;color:#63BE46">{{ $product->num }}</span>
                            <span style="height:1px;flex:0 0 34px;background:#CFE3CC"></span>
                            <span style="font-size:11.5px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#8A968E">{{ $product->tag }}</span>
                        </div>
                        <h3 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(25px,2.7vw,36px);line-height:1.1;letter-spacing:-0.01em;margin:10px 0 0;color:#123C2D">{{ $product->title }}</h3>
                        <p style="font-size:clamp(14.5px,1vw,15.5px);line-height:1.6;color:#5E6862;margin:11px 0 0;max-width:56ch">{{ $product->description }}</p>

                        @if ($product->specs->isNotEmpty())
                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(130px,100%),1fr));gap:11px 20px;margin-top:16px;max-width:600px">
                                @foreach ($product->specs as $spec)
                                    <div><div style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:#9AA69E;font-weight:700">{{ $spec->label }}</div><div style="font-size:15px;font-weight:700;color:#123C2D;margin-top:3px">{{ $spec->value }}</div></div>
                                @endforeach
                            </div>
                        @endif

                        <a href="#contact" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:9px;margin-top:18px;background:#2F8B3C;color:#FFFFFF;padding:12px 22px;border-radius:999px;font-size:14px;font-weight:600;box-shadow:0 10px 24px rgba(47,139,60,0.24)">View Details <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->count() > $initialRows)
            <div data-more-wrap style="margin-top:clamp(26px,3vw,38px)">
                <button type="button" data-more="products" data-step="{{ $moreStep }}" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:11px;background:#2F8B3C;color:#FFFFFF;border:none;padding:17px 34px;border-radius:999px;font-family:inherit;font-size:15.5px;font-weight:600;cursor:pointer;box-shadow:0 14px 34px rgba(47,139,60,0.28)">
                    View more <span data-more-count style="font-weight:500;opacity:0.75">({{ $products->count() - $initialRows }})</span>
                    <span aria-hidden="true" style="display:inline-flex;width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,0.2);align-items:center;justify-content:center">↓</span>
                </button>
            </div>
        @endif
    </div>
</section>
