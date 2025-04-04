<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'heading',
        'allergy_info',
        'ingredients_tagline',
        'theme_color'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function nutrition()
    {
        return $this->hasOne(Nutrition::class);
    }

    public function allergyInfo()
    {
        return $this->hasOne(AllergyInfo::class);
    }

    public function ingridients() {
        return $this->hasMany(Ingridient::class);
    }

}

