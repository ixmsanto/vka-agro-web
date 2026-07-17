@extends('layouts.admin', ['section' => 'inquiries'])

@section('title', 'Inquiries')
@section('crumb', 'Contact form')
@section('heading', 'Export inquiries')

@section('content')
    @if ($inquiries->isEmpty())
        <div class="a-card" style="border-radius:20px;padding:40px;text-align:center">
            <div style="font-size:15px;font-weight:600;color:#5E6862">No inquiries yet.</div>
            <div style="font-size:13.5px;color:#9AA69E;margin-top:6px">Submissions from the contact form on the live site will appear here.</div>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:14px">
            @foreach ($inquiries as $inquiry)
                <div class="a-card">
                    <div style="display:flex;flex-wrap:wrap;align-items:flex-start;justify-content:space-between;gap:12px">
                        <div style="min-width:0">
                            <div style="font-size:15.5px;font-weight:700;color:#21503C">{{ $inquiry->name }}@if ($inquiry->company)<span style="font-weight:500;color:#8A968E"> · {{ $inquiry->company }}</span>@endif</div>
                            <div style="font-size:13px;color:#5E6862;margin-top:4px">
                                <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>
                                @if ($inquiry->country)<span style="color:#9AA69E"> · {{ $inquiry->country }}</span>@endif
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;flex:0 0 auto">
                            <span style="font-size:12px;color:#9AA69E" title="{{ $inquiry->created_at }}">{{ $inquiry->created_at->diffForHumans() }}</span>
                            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" data-confirm="Delete this inquiry?" style="display:flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete" style="flex:0 0 auto;padding:6px 10px">✕</button>
                            </form>
                        </div>
                    </div>

                    @if ($inquiry->message)
                        <p style="font-size:14px;line-height:1.65;color:#3B4A42;margin:14px 0 0;white-space:pre-line">{{ $inquiry->message }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Hand-rolled: the framework's paginator views assume Tailwind, which this app doesn't ship. --}}
        @if ($inquiries->hasPages())
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:22px">
                @if ($inquiries->onFirstPage())
                    <span style="font-size:13.5px;color:#B7C1B9">← Newer</span>
                @else
                    <a href="{{ $inquiries->previousPageUrl() }}" style="font-size:13.5px;font-weight:600">← Newer</a>
                @endif

                <span style="font-size:12.5px;color:#9AA69E">Page {{ $inquiries->currentPage() }} of {{ $inquiries->lastPage() }}</span>

                @if ($inquiries->hasMorePages())
                    <a href="{{ $inquiries->nextPageUrl() }}" style="font-size:13.5px;font-weight:600">Older →</a>
                @else
                    <span style="font-size:13.5px;color:#B7C1B9">Older →</span>
                @endif
            </div>
        @endif
    @endif
@endsection
