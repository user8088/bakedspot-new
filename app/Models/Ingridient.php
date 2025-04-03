<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingridient extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'product_id',
        'image'
    ];

    // Define relationship with Product
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
