<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Cart;


use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $sessionId = Session::getId(); // Laravel session ID

        $cart = new Cart();
        $cart->session_id = $sessionId;
        $cart->pack_type = $request->pack_type;
        $cart->item_1 = $request->item_1;
        $cart->item_2 = $request->item_2;
        $cart->item_3 = $request->item_3;
        $cart->item_4 = $request->item_4;
        $cart->item_5 = $request->item_5;
        $cart->item_6 = $request->item_6;
        $cart->item_7 = $request->item_7;
        $cart->item_8 = $request->item_8;
        $cart->total_price = $request->total_price;
        $cart->save();
        return redirect()->back()->with('success', 'Cart added!');
    }
}
