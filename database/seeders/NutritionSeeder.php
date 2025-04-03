<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Nutrition;

class NutritionSeeder extends Seeder
{
    public function run()
    {
        $nutrition_data = [
            ['product_name' => 'Red Velvet Brownie', 'calories' => 690],
            ['product_name' => 'Triple Chocolate Brownie', 'calories' => 880],
            ['product_name' => 'Cookie Dough Brownie', 'calories' => 770],
            ['product_name' => 'Peanut Butter Brownie', 'calories' => 880],
            ['product_name' => 'Lemon Cheese Cake Brownie', 'calories' => 660],
            ['product_name' => 'Classic Brownie', 'calories' => 910],
        ];

        foreach ($nutrition_data as $data) {
            $product = Product::where('name', $data['product_name'])->first();
            if ($product) {
                Nutrition::create([
                    'product_id' => $product->id,
                    'calories' => $data['calories'],
                ]);
            }
        }
    }
}
