<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function getHomePage()
{
    $products = Product::all();
    // dd($products->first()->toArray());
    return view('client.modules.home', compact('products'));
}


    public function get_PackMenuPage()
    {
        return view('client.modules.packs-page');
    }

    public function get_PackFourPage(){
        return view('client.modules.pack-four-page');
    }

    public function get_PackEightPage(){
        return view('client.modules.pack-eight-page');
    }
}
