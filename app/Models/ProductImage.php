<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function url(string $size = 'medium'): string
    {
        $base = $size === 'original' ? 'products/original' : "products/{$size}";
        return Storage::url("{$base}/{$this->path}");
    }
}
