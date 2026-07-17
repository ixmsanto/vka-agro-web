{{-- ↑ / ↓ / ✕ for one collection row. Plain forms, so no JS required. --}}
<div style="display:flex;gap:6px;margin-top:10px">
    @foreach (['up' => '↑', 'down' => '↓'] as $direction => $glyph)
        <form method="POST" action="{{ route('admin.collection.move', [$resource, $item->id]) }}" style="flex:1;display:flex">
            @csrf
            <button type="submit" name="direction" value="{{ $direction }}" class="a-icon-btn" title="Move {{ $direction }}" aria-label="Move {{ $direction }}">{{ $glyph }}</button>
        </form>
    @endforeach

    <form method="POST" action="{{ route('admin.collection.destroy', [$resource, $item->id]) }}" data-confirm="Delete this {{ $config['singular'] }}? This cannot be undone." style="flex:1;display:flex">
        @csrf
        @method('DELETE')
        <button type="submit" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete">✕</button>
    </form>
</div>
