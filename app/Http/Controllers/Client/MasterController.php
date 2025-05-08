<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{
    public function getHomePage()
    {
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        return view('client.modules.home', compact('products'));
    }


    public function get_PackMenuPage()
    {
        // Only set order type to delivery if it's not already set
        if (!Session::has('order_type')) {
            Session::put('order_type', 'delivery');
        }

        $sectors = \App\Models\Sector::all();
        return view('client.modules.packs-page', compact('sectors'));
    }

    public function get_PackFourPage()
    {
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        $sectors = Sector::all();
        return view('client.modules.pack-four-page', compact('products', 'sectors'));
    }


    public function get_PackEightPage(){
        $products = Product::with('images')->get(); // 👈 eager load 'images'
        $sectors = Sector::all();
        return view('client.modules.pack-eight-page', compact('products', 'sectors'));
    }

    public function saveSectorSelection(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
        ]);

        $sector = Sector::findOrFail($request->sector_id);

        // Store sector information in session
        session([
            'selected_sector' => [
                'id' => $sector->id,
                'name' => $sector->sector_name,
                'delivery_charges' => $sector->delivery_charges
            ]
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery sector selected',
                'sector' => [
                    'id' => $sector->id,
                    'name' => $sector->sector_name,
                    'delivery_charges' => $sector->delivery_charges
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Delivery sector selected');
    }
}
