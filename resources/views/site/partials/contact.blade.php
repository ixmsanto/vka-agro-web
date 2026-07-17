@php
    $field = 'width:100%;box-sizing:border-box;padding:15px 16px;border:1px solid rgba(33,80,60,0.16);border-radius:12px;background:rgba(255,255,255,0.6);font-family:inherit;font-size:15px;color:#21503C;outline:none';
    $sent = session('inquiry_sent');
@endphp

<section id="contact" style="padding:clamp(80px,10vw,140px) 0;scroll-margin-top:80px">
    <div style="max-width:1400px;margin:0 auto;padding:0 clamp(20px,4vw,48px);display:flex;flex-wrap:wrap;gap:clamp(36px,5vw,80px)">
        <div style="flex:1 1 min(400px,100%)">
            <div data-reveal="0" style="font-size:12.5px;letter-spacing:0.16em;text-transform:uppercase;font-weight:700;color:#63BE46">Contact</div>
            <h2 data-reveal="1" style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(34px,3.8vw,56px);line-height:1.12;margin:20px 0 0;color:#21503C">Let's talk about your <span style="font-style:italic;color:#63BE46">next container.</span></h2>
            <p data-reveal="2" style="font-size:16.5px;line-height:1.75;color:rgba(33,80,60,0.72);margin:22px 0 0;max-width:48ch">{{ $contact['intro'] }}</p>

            <div data-reveal="3" style="display:flex;flex-direction:column;gap:14px;margin-top:36px">
                <div style="display:flex;gap:16px;align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:7px;flex:0 0 auto"></div>
                    <div><div style="font-size:13px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(33,80,60,0.6)">Export office</div><div style="font-size:16px;font-weight:600;color:#21503C;margin-top:4px">{{ $contact['address'] }}</div></div>
                </div>
                <div style="display:flex;gap:16px;align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:7px;flex:0 0 auto"></div>
                    <div><div style="font-size:13px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(33,80,60,0.6)">Email</div><a href="mailto:{{ $contact['email'] }}" style="font-size:16px;font-weight:600;color:#21503C;margin-top:4px;display:inline-block">{{ $contact['email'] }}</a></div>
                </div>
                <div style="display:flex;gap:16px;align-items:flex-start;background:rgba(255,255,255,0.42);border:1px solid rgba(255,255,255,0.6);border-radius:14px;padding:16px 20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)">
                    <div style="width:8px;height:8px;border-radius:50%;background:#63BE46;margin-top:7px;flex:0 0 auto"></div>
                    <div><div style="font-size:13px;letter-spacing:0.08em;text-transform:uppercase;color:rgba(33,80,60,0.6)">Phone · WhatsApp</div><a href="tel:{{ $contact['phoneHref'] }}" style="font-size:16px;font-weight:600;color:#21503C;margin-top:4px;display:inline-block">{{ $contact['phone'] }}</a></div>
                </div>
            </div>

            <div data-reveal="4" style="position:relative;margin-top:20px;height:220px;border-radius:16px;overflow:hidden;background:rgba(99,190,70,0.14);border:1px solid rgba(255,255,255,0.5)">
                <x-img-slot :src="\App\Models\Medium::url('contact-map')" placeholder="Map — a screenshot of Pollachi, Tamil Nadu" fit="cover" />
            </div>
        </div>

        <div data-reveal="2" style="flex:1 1 min(400px,100%);background:rgba(255,255,255,0.5);border:1px solid rgba(255,255,255,0.7);border-radius:24px;padding:clamp(28px,3vw,44px);align-self:flex-start;backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);box-shadow:0 24px 60px rgba(33,80,60,0.12)">
            <div style="font-size:18px;font-weight:700;color:#21503C">Export inquiry</div>

            @if ($sent)
                <div role="status" style="margin-top:24px;background:rgba(99,190,70,0.16);border:1px solid #63BE46;border-radius:14px;padding:18px 22px;font-size:15px;font-weight:600;color:#21503C">✓ Thank you — we'll reply within one business day.</div>
            @else
                <form method="POST" action="{{ route('inquiry.store') }}#contact" style="display:flex;flex-direction:column;gap:16px;margin-top:24px">
                    @csrf

                    {{-- Honeypot: real people never fill this in. --}}
                    <div style="position:absolute;left:-9999px" aria-hidden="true">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off" value=""></label>
                    </div>

                    @if ($errors->any())
                        <div role="alert" style="display:flex;flex-direction:column;gap:4px;background:rgba(214,80,60,0.1);border:1px solid rgba(214,80,60,0.35);border-radius:12px;padding:12px 15px;font-size:13.5px;font-weight:600;color:#B23B2A">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(200px,100%),1fr));gap:16px">
                        <input class="vka-field" type="text" name="name" value="{{ old('name') }}" placeholder="Full name" required autocomplete="name" style="{{ $field }}">
                        <input class="vka-field" type="text" name="company" value="{{ old('company') }}" placeholder="Company" autocomplete="organization" style="{{ $field }}">
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(200px,100%),1fr));gap:16px">
                        <input class="vka-field" type="email" name="email" value="{{ old('email') }}" placeholder="Work email" required autocomplete="email" style="{{ $field }}">
                        <input class="vka-field" type="text" name="country" value="{{ old('country') }}" placeholder="Country" autocomplete="country-name" style="{{ $field }}">
                    </div>
                    <textarea class="vka-field" name="message" rows="4" placeholder="Crop, volumes, target spec, destination port…" style="{{ $field }};resize:vertical">{{ old('message') }}</textarea>

                    <button type="submit" class="vka-btn-send" style="background:#63BE46;color:#FFFFFF;border:1px solid rgba(255,255,255,0.35);border-radius:999px;padding:17px 32px;font-family:inherit;font-size:15.5px;font-weight:600;cursor:pointer;box-shadow:0 12px 30px rgba(99,190,70,0.32);transition:background .3s ease, transform .3s ease">Send inquiry →</button>
                </form>
            @endif
        </div>
    </div>
</section>
