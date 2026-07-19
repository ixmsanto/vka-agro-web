<section id="testimonials" style="position:relative;padding:var(--section-y) 0;scroll-margin-top:80px">
    <x-deco shape="sparkle" size="20" pos="top:10%;right:5%" opacity="0.42" motion="drift" wide />
    <x-deco shape="arc" size="66" pos="top:18%;left:2%" opacity="0.21" motion="float-slow" delay="1.3s" rotate="180" wide />
    <x-deco shape="seed" size="26" pos="bottom:28%;right:4.5%" opacity="0.32" motion="float" delay="2.5s" rotate="18" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 var(--gutter);position:relative;z-index:1">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:var(--sp-6);margin-bottom:var(--header-gap)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:var(--sp-2);background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Testimonials
                </div>
                <h2 data-split="1" style="font-family:var(--font-display);font-weight:500;font-size:var(--fs-h2);line-height:var(--lh-heading);letter-spacing:var(--ls-heading);margin:var(--sp-4) 0 0;color:#123C2D">Trusted by growers <span style="font-style:italic;color:#63BE46">worldwide.</span></h2>
            </div>
            <div data-reveal="2" style="display:flex;align-items:center;gap:var(--sp-3)">
                <div style="display:flex;align-items:center;gap:var(--sp-1);color:#E0A233;font-size:var(--fs-lead);letter-spacing:2px" aria-hidden="true">★★★★★</div>
                <span style="font-size:var(--fs-sm);font-weight:600;color:#5E6862">4.9 / 5 · 300+ buyers</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(320px,100%),1fr));gap:clamp(16px,2vw,24px)">
            @foreach ($testimonials as $testimonial)
                <figure data-reveal="3" data-fx="scale" data-tilt="5" style="margin:0;background:#FFFFFF;border:1px solid #EEF3EC;border-radius:24px;padding:32px 30px;box-shadow:0 18px 50px rgba(33,80,60,0.08)">
                    <div style="display:flex;align-items:center;gap:var(--sp-1);color:#E0A233;font-size:var(--fs-body);letter-spacing:2px" aria-hidden="true">★★★★★</div>
                    <blockquote style="margin:0"><p style="font-size:var(--fs-body);line-height:var(--lh-body);color:#3B4A42;margin:var(--sp-4) 0 0">“{{ $testimonial->quote }}”</p></blockquote>
                    <figcaption style="display:flex;align-items:center;gap:var(--sp-3);margin-top:var(--sp-6);padding-top:22px;border-top:1px solid #EEF3EC">
                        <span style="position:relative;width:46px;height:46px;border-radius:50%;overflow:hidden;background:rgba(99,190,70,0.12);flex:0 0 auto">
                            <x-img-slot :src="\App\Support\MediaStore::url($testimonial->image_path)" :placeholder="$testimonial->name" :alt="$testimonial->name" fit="cover" circle />
                        </span>
                        <div><div style="font-size:var(--fs-body);font-weight:700;color:#123C2D">{{ $testimonial->name }}</div><div style="font-size:var(--fs-xs);color:#8A968E">{{ $testimonial->role }}</div></div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
