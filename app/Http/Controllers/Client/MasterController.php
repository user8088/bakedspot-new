<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function getHomePage()
    {
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        return view('client.modules.home', compact('products'));
    }


    public function get_PackMenuPage()
    {
        return view('client.modules.packs-page');
    }

    public function get_PackFourPage()
    {
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        return view('client.modules.pack-four-page', compact('products'));
    }


    public function get_PackEightPage(){
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        return view('client.modules.pack-eight-page', compact('products'));
    }
}
