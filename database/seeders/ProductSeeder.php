<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Red Velvet Brownie',
                'description' => 'A rich, moist red velvet brownie with a hint of cocoa and topped with a creamy frosting.',
                'price' => 250,
                'heading' => 'Delicious Red Velvet'
            ],
            [
                'name' => 'Triple Chocolate Brownie',
                'description' => 'Loaded with three types of chocolate, this brownie is an indulgent treat for chocolate lovers.',
                'price' => 250,
                'heading' => 'Chocolate Overload'
            ],
            [
                'name' => 'Cookie Dough Brownie',
                'description' => 'A soft, chewy brownie filled with chunks of cookie dough for the perfect sweet combination.',
                'price' => 250,
                'heading' => 'Soft and Crunchy'
            ],
            [
                'name' => 'Peanut Butter Brownie',
                'description' => 'A rich, fudgy brownie swirled with creamy peanut butter for a nutty twist.',
                'price' => 250,
                'heading' => 'Nutty Delight'
            ],
            [
                'name' => 'Lemon Cheese Cake Brownie',
                'description' => 'A refreshing lemon-infused brownie layered with creamy cheesecake for a tangy treat.',
                'price' => 250,
                'heading' => 'Tangy and Sweet'
            ],
            [
                'name' => 'Classic Brownie',
                'description' => 'A timeless fudgy brownie with a perfect balance of chewiness and crisp edges.',
                'price' => 250,
                'heading' => 'Timeless Classic'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

