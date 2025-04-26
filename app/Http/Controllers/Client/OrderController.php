<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function start_order(){
        return view('client.modules.order-location');
    }

    public function showCheckout()
    {
        return view('client.modules.checkout');
    }

    public function processCheckout(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'zip' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod'
        ]);

        try {
            // Get cart items
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('get-packmenupage')
                    ->with('error', 'Your cart is empty. Please add items to your cart before checkout.');
            }

            // Get selected sector/delivery area
            $selectedSector = session('selected_sector');
            if (!$selectedSector) {
                return redirect()->route('get-packmenupage')
                    ->with('error', 'Please select a delivery area before checkout.');
            }

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $deliveryCharges = $selectedSector['delivery_charges'];
            $total = $subtotal + $deliveryCharges;

            // Create order
            $order = Order::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'area' => $validated['area'],
                'postal_code' => $validated['zip'] ?? null,
                'delivery_notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'sector_id' => $selectedSector['id'],
                'delivery_charges' => $deliveryCharges,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'pending',
                'session_id' => $sessionId
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'pack_type' => $item->pack_type,
                    'item_1' => $item->item_1,
                    'item_2' => $item->item_2,
                    'item_3' => $item->item_3,
                    'item_4' => $item->item_4,
                    'item_5' => $item->item_5,
                    'item_6' => $item->item_6,
                    'item_7' => $item->item_7,
                    'item_8' => $item->item_8,
                    'price' => $item->total_price,
                    'quantity' => 1
                ]);
            }

            // Clear cart
            Cart::where('session_id', $sessionId)->delete();

            // Clear selected sector
            Session::forget('selected_sector');

            // Redirect to thank you page
            return redirect()->route('checkout.success', ['order_id' => $order->id])
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'There was an error processing your order. Please try again.')
                ->withInput();
        }
    }

    public function checkoutSuccess($order_id)
    {
        $order = Order::with('items')->findOrFail($order_id);
        return view('client.modules.checkout-success', compact('order'));
    }
}
