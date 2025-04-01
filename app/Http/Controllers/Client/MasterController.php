<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function get_ProductDetailsPage()
    {
        return view('client.modules.product-details-page');
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
