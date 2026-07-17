<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use Concerns\Sortable;

    protected $fillable = ['position', 'num', 'tag', 'title', 'description', 'image_path', 'image_placeholder'];

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class)->orderBy('position');
    }

    /** Fields the admin's autosave endpoint may write, and how each is validated. */
    public static function fieldRules(): array
    {
        return [
            'num' => ['nullable', 'string', 'max:10'],
            'tag' => ['nullable', 'string', 'max:60'],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
