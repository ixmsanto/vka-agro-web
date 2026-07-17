<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use Concerns\Sortable;

    protected $fillable = ['position', 'caption', 'col_span', 'row_span', 'image_path'];

    protected $casts = [
        'col_span' => 'integer',
        'row_span' => 'integer',
    ];

    public static function fieldRules(): array
    {
        return [
            'caption' => ['nullable', 'string', 'max:120'],
            'col_span' => ['required', 'integer', 'between:1,2'],
            'row_span' => ['required', 'integer', 'between:1,2'],
        ];
    }
}
