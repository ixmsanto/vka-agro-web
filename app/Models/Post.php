<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Concerns\Sortable;

    protected $fillable = ['position', 'category', 'read_time', 'title', 'excerpt', 'image_path'];

    public static function fieldRules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:40'],
            'read_time' => ['nullable', 'string', 'max:30'],
            'title' => ['nullable', 'string', 'max:160'],
            'excerpt' => ['nullable', 'string', 'max:500'],
        ];
    }
}
