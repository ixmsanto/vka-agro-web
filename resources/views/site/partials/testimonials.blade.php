<section id="testimonials" style="position:relative;padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <x-deco shape="sparkle" size="20" pos="top:10%;right:5%" opacity="0.42" motion="drift" wide />
    <x-deco shape="arc" size="66" pos="top:18%;left:2%" opacity="0.21" motion="float-slow" delay="1.3s" rotate="180" wide />
    <x-deco shape="seed" size="26" pos="bottom:28%;right:4.5%" opacity="0.32" motion="float" delay="2.5s" rotate="18" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px);position:relative;z-index:1">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:clamp(32px,4vw,52px)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Testimonials
                </div>
                <h2 data-split="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">Trusted by growers <span style="font-style:italic;color:#63BE46">worldwide.</span></h2>
            </div>
            <div data-reveal="2" style="display:flex;align-items:center;gap:14px">
                <div style="display:flex;align-items:center;gap:3px;color:#E0A233;font-size:18px;letter-spacing:2px" aria-hidden="true">★★★★★</div>
                <span style="font-size:14px;font-weight:600;color:#5E6862">4.9 / 5 · 300+ buyers</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(320px,100%),1fr));gap:clamp(16px,2vw,24px)">
            @foreach ($testimonials as $testimonial)
                <figure data-reveal="3" data-fx="scale" data-tilt="5" style="margin:0;background:#FFFFFF;border:1px solid #EEF3EC;border-radius:24px;padding:32px 30px;box-shadow:0 18px 50px rgba(33,80,60,0.08)">
                    <div style="display:flex;align-items:center;gap:3px;color:#E0A233;font-size:15px;letter-spacing:2px" aria-hidden="true">★★★★★</div>
                    <blockquote style="margin:0"><p style="font-size:16px;line-height:1.7;color:#3B4A42;margin:18px 0 0">“{{ $testimonial->quote }}”</p></blockquote>
                    <figcaption style="display:flex;align-items:center;gap:14px;margin-top:26px;padding-top:22px;border-top:1px solid #EEF3EC">
                        <span style="position:relative;width:46px;height:46px;border-radius:50%;overflow:hidden;background:rgba(99,190,70,0.12);flex:0 0 auto">
                            <x-img-slot :src="\App\Support\MediaStore::url($testimonial->image_path)" :placeholder="$testimonial->name" :alt="$testimonial->name" fit="cover" circle />
                        </span>
                        <div><div style="font-size:15px;font-weight:700;color:#123C2D">{{ $testimonial->name }}</div><div style="font-size:13px;color:#8A968E">{{ $testimonial->role }}</div></div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
