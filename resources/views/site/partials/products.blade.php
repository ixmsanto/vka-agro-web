<section id="products" style="padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px">
            <div style="max-width:600px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Our Products
                </div>
                <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">One raw material, <span style="font-style:italic;color:#63BE46">every format</span> you grow with.</h2>
            </div>
            <p data-reveal="2" style="font-size:clamp(15px,1.1vw,17px);line-height:1.7;color:#5E6862;max-width:38ch;margin:0">Blocks, briquettes, grow bags and husk chips — buffered, low-EC and pressed to export spec.</p>
        </div>

        <div style="display:flex;flex-direction:column;gap:clamp(48px,7vw,104px);margin-top:clamp(48px,6vw,80px)">
            @foreach ($products as $product)
                <div data-prow style="display:flex;flex-wrap:wrap;align-items:center;gap:clamp(28px,5vw,72px)">
                    <div data-reveal="3" style="flex:1 1 min(380px,100%);position:relative;aspect-ratio:5 / 4;border-radius:28px;overflow:hidden;background:rgba(99,190,70,0.1);box-shadow:0 30px 70px rgba(33,80,60,0.14)">
                        <x-img-slot :src="\App\Support\MediaStore::url($product->image_path)" :placeholder="$product->image_placeholder" :alt="$product->title" fit="cover" />
                    </div>
                    <div data-reveal="4" style="flex:1 1 min(380px,100%)">
                        <div style="display:flex;align-items:center;gap:12px">
                            <span style="font-family:'Newsreader',serif;font-size:22px;color:#63BE46">{{ $product->num }}</span>
                            <span style="height:1px;flex:0 0 34px;background:#CFE3CC"></span>
                            <span style="font-size:11.5px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#8A968E">{{ $product->tag }}</span>
                        </div>
                        <h3 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(28px,3.2vw,42px);line-height:1.1;letter-spacing:-0.01em;margin:14px 0 0;color:#123C2D">{{ $product->title }}</h3>
                        <p style="font-size:clamp(15px,1.1vw,16.5px);line-height:1.72;color:#5E6862;margin:16px 0 0;max-width:56ch">{{ $product->description }}</p>

                        @if ($product->specs->isNotEmpty())
                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:14px 24px;margin-top:24px;max-width:460px">
                                @foreach ($product->specs as $spec)
                                    <div><div style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:#9AA69E;font-weight:700">{{ $spec->label }}</div><div style="font-size:15px;font-weight:700;color:#123C2D;margin-top:3px">{{ $spec->value }}</div></div>
                                @endforeach
                            </div>
                        @endif

                        <a href="#contact" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:10px;margin-top:28px;background:#2F8B3C;color:#FFFFFF;padding:14px 26px;border-radius:999px;font-size:14.5px;font-weight:600;box-shadow:0 12px 28px rgba(47,139,60,0.26)">View Details <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            @endforeach
        </div>

        <div data-reveal="7" style="display:flex;justify-content:center;margin-top:clamp(40px,5vw,56px)">
            <a href="#contact" class="vka-btn-primary" style="display:inline-flex;align-items:center;gap:11px;background:#2F8B3C;color:#FFFFFF;padding:17px 34px;border-radius:999px;font-size:15.5px;font-weight:600;box-shadow:0 14px 34px rgba(47,139,60,0.28)">Request full catalogue <span aria-hidden="true" style="display:inline-flex;width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,0.2);align-items:center;justify-content:center">→</span></a>
        </div>
    </div>
</section>
