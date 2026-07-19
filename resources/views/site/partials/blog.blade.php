<section id="blog" style="position:relative;padding:var(--section-y) 0;scroll-margin-top:80px">
    <x-deco shape="sprout" size="32" pos="top:9%;right:4%" opacity="0.34" motion="drift" wide />
    <x-deco shape="dots" size="40" pos="bottom:12%;left:3%" opacity="0.25" motion="float-slow" delay="1.7s" wide />
    <x-deco shape="wave" size="42" pos="top:20%;left:2.5%" opacity="0.25" motion="float" delay="2.4s" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 var(--gutter);position:relative;z-index:1">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:var(--sp-6);margin-bottom:var(--header-gap)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:var(--sp-2);background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Insights
                </div>
                <h2 data-split="1" style="font-family:var(--font-display);font-weight:500;font-size:var(--fs-h2);line-height:var(--lh-heading);letter-spacing:var(--ls-heading);margin:var(--sp-4) 0 0;color:#123C2D">Guides from the <span style="font-style:italic;color:#63BE46">growing floor.</span></h2>
            </div>
            <a data-reveal="2" href="#blog" class="vka-btn-ghost" style="display:inline-flex;align-items:center;gap:var(--sp-2);background:rgba(255,255,255,0.7);border:1.5px solid #CFE3CC;color:#2F8B3C;padding:13px 24px;border-radius:999px;font-size:var(--fs-sm);font-weight:600">All articles <span aria-hidden="true">→</span></a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(300px,100%),1fr));gap:clamp(18px,2vw,26px)">
            @foreach ($posts as $post)
                <a data-reveal="3" data-fx="scale" data-tilt="4" href="#blog" class="vka-blog-card" style="display:block;background:#FFFFFF;border:1px solid #EEF3EC;border-radius:24px;overflow:hidden;box-shadow:0 18px 50px rgba(33,80,60,0.08)">
                    <div style="position:relative;aspect-ratio:16 / 10;background:rgba(99,190,70,0.1)">
                        <x-img-slot :src="\App\Support\MediaStore::url($post->image_path)" placeholder="Article cover" :alt="$post->title" fit="cover" />
                    </div>
                    <div style="padding:24px 24px 28px">
                        <div style="display:flex;align-items:center;gap:var(--sp-3);font-size:var(--fs-eyebrow);font-weight:700;letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:#2F8B3C"><span>{{ $post->category }}</span><span style="width:3px;height:3px;border-radius:50%;background:#CBD9C6"></span><span style="color:#9AA69E">{{ $post->read_time }}</span></div>
                        <h3 style="font-size:var(--fs-h3);font-weight:700;line-height:var(--lh-snug);color:#123C2D;margin:var(--sp-3) 0 0">{{ $post->title }}</h3>
                        <p style="font-size:var(--fs-sm);line-height:var(--lh-body);color:#7A857E;margin:var(--sp-3) 0 0">{{ $post->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
