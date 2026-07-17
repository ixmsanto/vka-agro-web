<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpec extends Model
{
    use Concerns\FlushesSiteCache;

    protected $fillable = ['product_id', 'position', 'label', 'value'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function fieldRules(): array
    {
        return [
            'label' => ['nullable', 'string', 'max:80'],
            'value' => ['nullable', 'string', 'max:80'],
        ];
    }
}
