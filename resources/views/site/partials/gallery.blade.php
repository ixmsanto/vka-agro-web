<section id="gallery" style="padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <div style="max-width:1440px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:clamp(32px,4vw,52px)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Gallery
                </div>
                <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">From our floor to <span style="font-style:italic;color:#63BE46">your greenhouse.</span></h2>
            </div>
            <p data-reveal="2" style="font-size:clamp(15px,1.1vw,17px);line-height:1.7;color:#5E6862;max-width:36ch;margin:0">A look inside the plantation, processing line and export-ready product.</p>
        </div>

        <div data-gallery style="display:grid;grid-template-columns:repeat(4,1fr);grid-auto-rows:220px;gap:clamp(12px,1.4vw,18px)">
            @foreach ($gallery as $tile)
                <div data-gtile data-col="{{ $tile->col_span }}" data-row="{{ $tile->row_span }}" data-reveal="3" style="position:relative;border-radius:24px;overflow:hidden;background:rgba(99,190,70,0.1);box-shadow:0 20px 50px rgba(33,80,60,0.1);grid-column:span {{ $tile->col_span }};grid-row:span {{ $tile->row_span }}">
                    <div data-gimg style="position:absolute;inset:0;transition:transform .8s cubic-bezier(.16,1,.3,1)">
                        <x-img-slot :src="\App\Support\MediaStore::url($tile->image_path)" :placeholder="$tile->caption" fit="cover" />
                    </div>
                    <div style="position:absolute;inset:0;pointer-events:none;background:linear-gradient(180deg,transparent 48%,rgba(14,42,32,0.62) 100%)"></div>
                    <span style="position:absolute;left:18px;bottom:16px;color:#FFFFFF;font-size:14px;font-weight:600;text-shadow:0 2px 8px rgba(0,0,0,0.3)">{{ $tile->caption }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
