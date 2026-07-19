@php
    $field = 'width:100%;box-sizing:border-box;padding:15px 16px;border:1px solid rgba(33,80,60,0.16);border-radius:12px;background:rgba(255,255,255,0.6);font-family:inherit;font-size:var(--fs-body);color:#21503C;outline:none';
    $sent = session('inquiry_sent');
@endphp

<section id="contact" style="position:relative;padding:var(--section-y) 0;scroll-margin-top:80px">
    <x-deco shape="leaf" size="34" pos="top:8%;left:3%" opacity="0.34" motion="drift" rotate="-20" wide />
    <x-deco shape="ring" size="60" pos="top:14%;right:3.5%" opacity="0.23" motion="float-slow" delay="1.2s" wide />
    <x-deco shape="sparkle" size="18" pos="bottom:9%;left:2.5%" opacity="0.38" motion="float" delay="2.2s" wide />
    <x-deco shape="dots" size="44" pos="bottom:30%;right:5%" opacity="0.25" motion="drift" delay="3s" wide />

    <div style="max-width:1400px;margin:0 auto;padding:0 var(--gutter);position:relative;z-index:1;display:flex;flex-wrap:wrap;gap:clamp(36px,5vw,80px)">
        <div style="flex:1 1 min(400px,100%)">
            <div data-reveal="0" style="font-size:var(--fs-xs);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;font-weight:700;color:#63BE46">Contact</div>
            <h2 data-split="1" style="font-family:var(--font-display);font-weight:500;font-size:var(--fs-h2);line-height:var(--lh-heading);margin:var(--sp-5) 0 0;color:#21503C">Let's talk about your <span style="font-style:italic;color:#63BE46">next container.</span></h2>
            <p data-reveal="2" style="font-size:var(--fs-lead);line-height:var(--lh-body);color:rgba(33,80,60,0.72);margin:var(--sp-5) 0 0;max-width:48ch">{{ $contact['intro'] }}</p>

            <div data-reveal="3" style="display:flex;flex-direction:column;gap:var(--sp-3);margin-top:var(--sp-7)">
                <div style="display:flex;gap:var(--sp-4);align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:var(--sp-2);flex:0 0 auto"></div>
                    <div><div style="font-size:var(--fs-xs);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:rgba(33,80,60,0.6)">Export office</div><div style="font-size:var(--fs-body);font-weight:600;color:#21503C;margin-top:var(--sp-1)">{{ $contact['address'] }}</div></div>
                </div>
                <div style="display:flex;gap:var(--sp-4);align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:var(--sp-2);flex:0 0 auto"></div>
                    <div><div style="font-size:var(--fs-xs);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:rgba(33,80,60,0.6)">Email</div><a href="mailto:{{ $contact['email'] }}" style="font-size:var(--fs-body);font-weight:600;color:#21503C;margin-top:var(--sp-1);display:inline-block">{{ $contact['email'] }}</a></div>
                </div>
                <div style="display:flex;gap:var(--sp-4);align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:var(--sp-2);flex:0 0 auto"></div>
                    <div><div style="font-size:var(--fs-xs);letter-spacing:var(--ls-eyebrow);text-transform:uppercase;color:rgba(33,80,60,0.6)">Phone · WhatsApp</div><a href="tel:{{ $contact['phoneHref'] }}" style="font-size:var(--fs-body);font-weight:600;color:#21503C;margin-top:var(--sp-1);display:inline-block">{{ $contact['phone'] }}</a></div>
                </div>
            </div>

            <div data-reveal="4" data-fx="mask" style="position:relative;margin-top:var(--sp-5);height:220px;border-radius:16px;overflow:hidden;background:rgba(99,190,70,0.14);border:1px solid rgba(255,255,255,0.5)">
                <x-img-slot :src="\App\Models\Medium::url('contact-map')" placeholder="Map — a screenshot of Pollachi, Tamil Nadu" fit="cover" />
            </div>
        </div>

        <div data-reveal="2" style="flex:1 1 min(400px,100%);background:rgba(255,255,255,0.5);border:1px solid rgba(255,255,255,0.7);border-radius:24px;padding:clamp(28px,3vw,44px);align-self:flex-start;backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);box-shadow:0 24px 60px rgba(33,80,60,0.12)">
            <div style="font-size:var(--fs-lead);font-weight:700;color:#21503C">Export inquiry</div>

            @if ($sent)
                <div role="status" style="margin-top:var(--sp-6);background:rgba(99,190,70,0.16);border:1px solid #63BE46;border-radius:14px;padding:18px 22px;font-size:var(--fs-body);font-weight:600;color:#21503C">✓ Thank you — we'll reply within one business day.</div>
            @else
                <form method="POST" action="{{ route('inquiry.store') }}#contact" style="display:flex;flex-direction:column;gap:var(--sp-4);margin-top:var(--sp-6)">
                    @csrf

                    {{-- Honeypot: real people never fill this in. --}}
                    <div style="position:absolute;left:-9999px" aria-hidden="true">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off" value=""></label>
                    </div>

                    @if ($errors->any())
                        <div role="alert" style="display:flex;flex-direction:column;gap:var(--sp-1);background:rgba(214,80,60,0.1);border:1px solid rgba(214,80,60,0.35);border-radius:12px;padding:12px 15px;font-size:var(--fs-sm);font-weight:600;color:#B23B2A">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(200px,100%),1fr));gap:var(--sp-4)">
                        <input class="vka-field" type="text" name="name" value="{{ old('name') }}" placeholder="Full name" required autocomplete="name" style="{{ $field }}">
                        <input class="vka-field" type="text" name="company" value="{{ old('company') }}" placeholder="Company" autocomplete="organization" style="{{ $field }}">
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(200px,100%),1fr));gap:var(--sp-4)">
                        <input class="vka-field" type="email" name="email" value="{{ old('email') }}" placeholder="Work email" required autocomplete="email" style="{{ $field }}">
                        <input class="vka-field" type="text" name="country" value="{{ old('country') }}" placeholder="Country" autocomplete="country-name" style="{{ $field }}">
                    </div>
                    <textarea class="vka-field" name="message" rows="4" placeholder="Crop, volumes, target spec, destination port…" style="{{ $field }};resize:vertical">{{ old('message') }}</textarea>

                    <button type="submit" class="vka-btn-send" style="background:#63BE46;color:#FFFFFF;border:1px solid rgba(255,255,255,0.35);border-radius:999px;padding:17px 32px;font-family:inherit;font-size:var(--fs-body);font-weight:600;cursor:pointer;box-shadow:0 12px 30px rgba(99,190,70,0.32);transition:background .3s ease, transform .3s ease">Send inquiry →</button>
                </form>
            @endif
        </div>
    </div>
</section>
