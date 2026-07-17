<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Manual `position` ordering with adjacent-swap reordering, matching the
 * design's ↑ / ↓ / ✕ controls.
 */
trait Sortable
{
    use FlushesSiteCache;

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('id');
    }

    public static function nextPosition(): int
    {
        return (int) static::query()->max('position') + 1;
    }

    public function moveUp(): void
    {
        $this->swapWith(
            static::query()
                ->where('position', '<=', $this->position)
                ->whereKeyNot($this->getKey())
                ->orderByDesc('position')
                ->orderByDesc('id')
                ->first()
        );
    }

    public function moveDown(): void
    {
        $this->swapWith(
            static::query()
                ->where('position', '>=', $this->position)
                ->whereKeyNot($this->getKey())
                ->orderBy('position')
                ->orderBy('id')
                ->first()
        );
    }

    /**
     * Swap positions with a neighbour. Rows seeded with duplicate positions
     * would otherwise deadlock the swap, so fall back to nudging past it.
     */
    protected function swapWith(?self $other): void
    {
        if (! $other) {
            return;
        }

        DB::transaction(function () use ($other) {
            $mine = $this->position;
            $theirs = $other->position;

            if ($mine === $theirs) {
                $theirs = $mine + ($other->getKey() > $this->getKey() ? 1 : -1);
            }

            $this->forceFill(['position' => $theirs])->save();
            $other->forceFill(['position' => $mine])->save();
        });
    }
}
