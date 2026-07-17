<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin login · VKA Agro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ $assetVersion }}">
</head>
<body class="vka-login">
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:clamp(20px,5vw,48px);box-sizing:border-box">
    <div class="vka-login-grid" style="width:100%;max-width:940px;display:grid;background:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.7);border-radius:28px;overflow:hidden;box-shadow:0 40px 100px rgba(33,80,60,0.20);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px)">

        <div class="vka-login-brand" style="position:relative;padding:clamp(36px,4vw,52px);background:linear-gradient(160deg,#21503C,#123C2D);color:#fff;flex-direction:column;justify-content:space-between;overflow:hidden">
            <div style="position:absolute;width:340px;height:340px;border-radius:50%;right:-120px;top:-120px;background:radial-gradient(closest-side,rgba(99,190,70,0.42),transparent 70%)"></div>
            <div style="position:relative;z-index:1">
                <div style="font-family:'Newsreader',serif;font-size:30px;line-height:1">VKA<span style="font-style:italic;color:#63BE46">&nbsp;Agro</span></div>
                <div style="font-size:12px;letter-spacing:0.16em;text-transform:uppercase;color:rgba(255,255,255,0.6);margin-top:8px">Content Management</div>
            </div>
            <div style="position:relative;z-index:1">
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(99,190,70,0.22);display:flex;align-items:center;justify-content:center;color:#63BE46">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h2 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(26px,2.4vw,34px);line-height:1.12;margin:20px 0 0">Manage your <span style="font-style:italic;color:#63BE46">catalogue,</span> stories &amp; site.</h2>
                <p style="font-size:14px;line-height:1.65;color:rgba(255,255,255,0.72);margin:14px 0 0;max-width:32ch">Sign in to edit products, blog posts, gallery, testimonials and contact details — changes publish straight to the live site.</p>
            </div>
            <div style="position:relative;z-index:1;display:flex;gap:8px;flex-wrap:wrap">
                @foreach (['Products', 'Blog', 'Gallery', 'Testimonials'] as $chip)
                    <span style="font-size:11px;font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);border-radius:999px;padding:5px 11px">{{ $chip }}</span>
                @endforeach
            </div>
        </div>

        <div style="padding:clamp(34px,4vw,54px);display:flex;flex-direction:column;justify-content:center">
            <div style="font-size:12px;letter-spacing:0.16em;text-transform:uppercase;font-weight:700;color:#2F8B3C">Admin Login</div>
            <h1 style="font-family:'Newsreader',serif;font-weight:400;font-size:clamp(30px,3vw,40px);line-height:1.08;margin:12px 0 0;color:#21503C">Welcome back</h1>
            <p style="font-size:14.5px;line-height:1.6;color:#6A756E;margin:10px 0 0">Enter your credentials to open the dashboard.</p>

            <form method="POST" action="{{ route('admin.login') }}" style="display:flex;flex-direction:column;gap:16px;margin-top:28px">
                @csrf

                <label class="a-label">
                    <span style="font-size:13px;font-weight:600;color:#3B4A42">Username or email</span>
                    <input class="a-input" type="text" name="username" value="{{ old('username') }}" autocomplete="username" placeholder="admin" required autofocus style="padding:14px 16px;border-radius:12px;background:rgba(255,255,255,0.7);font-size:15px">
                </label>

                <label class="a-label">
                    <span style="font-size:13px;font-weight:600;color:#3B4A42">Password</span>
                    <input class="a-input" type="password" name="password" autocomplete="current-password" placeholder="••••••••" required style="padding:14px 16px;border-radius:12px;background:rgba(255,255,255,0.7);font-size:15px">
                </label>

                <label style="display:flex;align-items:center;gap:9px;font-size:13.5px;color:#3B4A42">
                    <input type="checkbox" name="remember" value="1" style="width:16px;height:16px;accent-color:#2F8B3C">
                    Keep me signed in
                </label>

                @if ($errors->any())
                    <div role="alert" style="display:flex;align-items:center;gap:9px;background:rgba(214,80,60,0.1);border:1px solid rgba(214,80,60,0.35);border-radius:12px;padding:12px 15px;font-size:13.5px;font-weight:600;color:#B23B2A">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex:0 0 auto"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="a-btn" style="margin-top:4px;justify-content:center;padding:16px 28px;font-size:15.5px;box-shadow:0 14px 32px rgba(47,139,60,0.3)">Sign in →</button>
            </form>

            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:7px;margin-top:24px;font-size:13.5px;font-weight:600">← Back to website</a>
        </div>

    </div>
</div>
</body>
</html>
