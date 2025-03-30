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
}
