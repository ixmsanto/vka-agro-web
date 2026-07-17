<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use Concerns\Sortable;

    protected $fillable = ['position', 'quote', 'name', 'role', 'image_path'];

    public static function fieldRules(): array
    {
        return [
            'quote' => ['nullable', 'string', 'max:1000'],
            'name' => ['nullable', 'string', 'max:80'],
            'role' => ['nullable', 'string', 'max:120'],
        ];
    }
}
