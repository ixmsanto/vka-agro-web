@extends('layouts.admin', ['section' => 'dashboard'])

@section('title', 'Dashboard')
@section('crumb', 'Overview')
@section('heading', 'Dashboard')

@section('content')
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(200px,100%),1fr));gap:16px">
        @foreach ($stats as $stat)
            <a href="{{ $stat['route'] }}" class="a-card" style="display:block;padding:22px;transition:transform .25s ease, box-shadow .25s ease">
                <div style="font-size:13px;font-weight:600;color:#8A968E">{{ $stat['label'] }}</div>
                <div style="font-family:'Newsreader',serif;font-size:44px;line-height:1;color:#2F8B3C;margin-top:10px">{{ $stat['count'] }}</div>
                <div style="font-size:12.5px;color:#9AA69E;margin-top:8px">{{ $stat['hint'] }}</div>
            </a>
        @endforeach
    </div>

    @if ($unread)
        <div style="margin-top:20px;background:rgba(99,190,70,0.12);border:1px solid rgba(47,139,60,0.3);border-radius:14px;padding:14px 18px;font-size:14px;font-weight:600;color:#2F8B3C">
            You have {{ $unread }} unread {{ \Illuminate\Support\Str::plural('inquiry', $unread) }}. <a href="{{ route('admin.inquiries.index') }}" style="text-decoration:underline">Read them →</a>
        </div>
    @endif

    <div class="a-card" style="margin-top:24px;border-radius:20px;padding:clamp(22px,3vw,32px)">
        <h2 style="font-family:'Newsreader',serif;font-weight:400;font-size:24px;margin:0;color:#21503C">Welcome back 👋</h2>
        <p style="font-size:14.5px;line-height:1.7;color:#5E6862;margin:12px 0 0;max-width:64ch">Edit any section from the sidebar. Text fields save automatically as you type. Images are managed by dropping files onto the slots — either here or under <a href="{{ route('admin.media.index') }}">Images &amp; video</a>. Changes publish to the live site immediately.</p>
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:22px">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="a-btn">Open live site ↗</a>
        </div>
    </div>
@endsection
