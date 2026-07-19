@php
    // Tiles shown before the visitor asks for more, and how many each press adds.
    $initialTiles = 8;
    $moreStep = 8;
@endphp

<section id="gallery" style="position:relative;padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <x-deco shape="wave" size="46" pos="top:8%;right:4%" opacity="0.27" motion="drift" wide />
    <x-deco shape="sparkle" size="16" pos="top:15%;left:4%" opacity="0.38" motion="float" delay="1.1s" wide />
    <x-deco shape="ring" size="54" pos="bottom:16%;left:2.5%" opacity="0.23" motion="float-slow" delay="2.1s" wide />

    <div style="max-width:1440px;margin:0 auto;padding:0 clamp(20px,4vw,48px);position:relative;z-index:1">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:clamp(32px,4vw,52px)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Gallery
                </div>
                <h2 data-split="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">From our floor to <span style="font-style:italic;color:#63BE46">your greenhouse.</span></h2>
            </div>
            <p data-reveal="2" style="font-size:clamp(15px,1.1vw,17px);line-height:1.7;color:#5E6862;max-width:36ch;margin:0">A look inside the plantation, processing line and export-ready product.</p>
        </div>

        <div data-gallery>
            @foreach ($gallery as $tile)
                <div data-gtile data-reveal="3" data-fx="scale" @if ($loop->index >= $initialTiles) data-more-item="gallery" @endif style="position:relative;border-radius:18px;overflow:hidden;background:rgba(99,190,70,0.1);box-shadow:0 14px 34px rgba(33,80,60,0.09)">
                    <div data-gimg style="display:block;transition:transform .8s cubic-bezier(.16,1,.3,1)">
                        <x-img-slot :src="\App\Support\MediaStore::url($tile->image_path)" :size="\App\Support\MediaStore::size($tile->image_path)" :placeholder="$tile->caption" fit="natural" />
                    </div>
                    <div data-gscrim style="position:absolute;inset:0;pointer-events:none;background:linear-gradient(180deg,transparent 52%,rgba(14,42,32,0.62) 100%)"></div>
                    <span data-gcap style="position:absolute;left:14px;bottom:12px;color:#FFFFFF;font-size:13px;font-weight:600;text-shadow:0 2px 8px rgba(0,0,0,0.3)">{{ $tile->caption }}</span>
                </div>
            @endforeach
        </div>

        @if ($gallery->count() > $initialTiles)
            <div data-more-wrap style="margin-top:clamp(32px,4vw,48px)">
                <button type="button" data-more="gallery" data-step="{{ $moreStep }}" class="vka-btn-ghost" style="display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.7);border:1.5px solid #CFE3CC;color:#2F8B3C;padding:15px 30px;border-radius:999px;font-family:inherit;font-size:15px;font-weight:600;cursor:pointer">
                    View more photos <span data-more-count style="font-weight:500;opacity:0.7">({{ $gallery->count() - $initialTiles }})</span>
                    <span aria-hidden="true">↓</span>
                </button>
            </div>
        @endif
    </div>
</section>
