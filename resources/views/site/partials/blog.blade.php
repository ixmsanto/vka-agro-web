<section id="blog" style="padding:clamp(64px,9vw,120px) 0;scroll-margin-top:80px">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:clamp(32px,4vw,52px)">
            <div style="max-width:620px">
                <div data-reveal="0" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                    <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                    Insights
                </div>
                <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,4.4vw,60px);line-height:1.06;letter-spacing:-0.015em;margin:18px 0 0;color:#123C2D">Guides from the <span style="font-style:italic;color:#63BE46">growing floor.</span></h2>
            </div>
            <a data-reveal="2" href="#blog" class="vka-btn-ghost" style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.7);border:1.5px solid #CFE3CC;color:#2F8B3C;padding:13px 24px;border-radius:999px;font-size:14.5px;font-weight:600">All articles <span aria-hidden="true">→</span></a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(300px,100%),1fr));gap:clamp(18px,2vw,26px)">
            @foreach ($posts as $post)
                <a data-reveal="3" href="#blog" class="vka-blog-card" style="display:block;background:#FFFFFF;border:1px solid #EEF3EC;border-radius:24px;overflow:hidden;box-shadow:0 18px 50px rgba(33,80,60,0.08)">
                    <div style="position:relative;aspect-ratio:16 / 10;background:rgba(99,190,70,0.1)">
                        <x-img-slot :src="\App\Support\MediaStore::url($post->image_path)" placeholder="Article cover" :alt="$post->title" fit="cover" />
                    </div>
                    <div style="padding:24px 24px 28px">
                        <div style="display:flex;align-items:center;gap:12px;font-size:12px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#2F8B3C"><span>{{ $post->category }}</span><span style="width:3px;height:3px;border-radius:50%;background:#CBD9C6"></span><span style="color:#9AA69E">{{ $post->read_time }}</span></div>
                        <h3 style="font-size:20px;font-weight:700;line-height:1.3;color:#123C2D;margin:14px 0 0">{{ $post->title }}</h3>
                        <p style="font-size:14.5px;line-height:1.6;color:#7A857E;margin:12px 0 0">{{ $post->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
