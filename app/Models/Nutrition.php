<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    use HasFactory;
    protected $table = 'nutritions'; // Ensure this matches your database table name

    protected $fillable = [
        'product_id',
        'calories',
        'fat',
        'carbohydrates',
        'protein',
        'sugar',
        'fiber',
        'sodium'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

