<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'product_id',
        'home_image_url',
        'detail_image_url',
        'pack_image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
