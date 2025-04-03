<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product; // Make sure Product model is imported
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function get_ProductDetailsPage($id)
    {
        // Fetch the product by ID
        $product = Product::findOrFail($id); // If product doesn't exist, it will return 404

        // Pass the product to the view
        return view('client.modules.product-details-page', compact('product'));
    }
}
