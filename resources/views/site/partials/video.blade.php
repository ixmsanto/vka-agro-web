@php
    $poster = \App\Models\Medium::url('video-poster');
    $file = \App\Models\Medium::url('facility-video');
@endphp

{{-- The top padding is measured and overwritten by site.js, which slides the
     hero's feature strip down over this boundary. --}}
<section id="video" style="padding:clamp(20px,4vw,60px) 0 clamp(52px,6vw,84px)">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">
        <div data-reveal="1" style="text-align:center;max-width:640px;margin:0 auto clamp(22px,2.6vw,34px)">
            <div style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.75);border:1px solid #E1EFDD;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;letter-spacing:0.11em;text-transform:uppercase;color:#2F8B3C">
                <span class="vka-pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#63BE46"></span>
                {{ $video['badge'] }}
            </div>
            <h2 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(28px,3.4vw,44px);line-height:1.04;letter-spacing:-0.015em;margin:14px 0 0;color:#123C2D">{{ $video['headingPre'] }}<span style="font-style:italic;color:#63BE46">{{ $video['headingAccent'] }}</span></h2>
            <p style="font-size:clamp(14.5px,1vw,15.5px);line-height:1.6;color:#5E6862;margin:11px auto 0;max-width:520px">{{ $video['subtitle'] }}</p>
        </div>

        {{-- Capped rather than full-bleed: at 16:9 the player's height is its
             width, so spanning the whole container made it 725px tall and the
             tallest thing on the page. --}}
        <div data-reveal="2" style="position:relative;width:100%;max-width:980px;margin:0 auto;aspect-ratio:2400 / 1350;border-radius:clamp(16px,1.6vw,22px);overflow:hidden;box-shadow:0 26px 60px rgba(33,80,60,0.2), 0 10px 24px rgba(33,80,60,0.09);background:#0E2A20">
            <video id="vka-video" playsinline preload="metadata" @if ($poster) poster="{{ $poster }}" @endif style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block">
                @if ($file)
                    <source src="{{ $file }}">
                @endif
            </video>

            <div id="vka-video-poster" style="position:absolute;inset:0;z-index:2">
                <x-img-slot :src="$poster" placeholder="Video poster image (landscape 2400×1350)" fit="cover" />
                <div style="position:absolute;inset:0;pointer-events:none;background:linear-gradient(180deg, rgba(14,42,32,0.15) 0%, transparent 30%, rgba(14,42,32,0.55) 100%)"></div>
            </div>

            {{-- Only offer play when a video has actually been uploaded. --}}
            @if ($file)
                <button id="vka-video-play" type="button" aria-label="Play video" class="vka-play" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:3;width:clamp(64px,6vw,88px);height:clamp(64px,6vw,88px);border:none;border-radius:50%;background:rgba(255,255,255,0.92);box-shadow:0 16px 40px rgba(0,0,0,0.28);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:transform .35s cubic-bezier(.16,1,.3,1), background .3s ease">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="#2F8B3C" aria-hidden="true" style="margin-left:4px"><path d="M8 5v14l11-7L8 5Z"/></svg>
                </button>
            @endif

            <div style="position:absolute;left:clamp(16px,2vw,28px);bottom:clamp(16px,2vw,28px);z-index:3;display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.85);border-radius:999px;padding:8px 15px;font-size:12.5px;font-weight:600;color:#21503C;backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2F8B3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7Z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                {{ $video['caption'] }}
            </div>
        </div>
    </div>
</section>
