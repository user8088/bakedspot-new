<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $sessionId = Session::getId();

            // Validate request data with more lenient rules
            $validated = $request->validate([
                'pack_type' => 'required|string',
                'total_price' => 'required|numeric',
                'item_1' => 'nullable|string',
                'item_2' => 'nullable|string',
                'item_3' => 'nullable|string',
                'item_4' => 'nullable|string',
                'item_5' => 'nullable|string',
                'item_6' => 'nullable|string',
                'item_7' => 'nullable|string',
                'item_8' => 'nullable|string',
            ]);

            Log::info('Adding to cart - Session ID: ' . $sessionId);
            Log::info('Request data: ' . json_encode($request->all()));

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
            Log::info('Cart item saved successfully');

            // Get updated cart count
            $cartCount = Cart::where('session_id', $sessionId)->count();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully',
                    'cartCount' => $cartCount
                ]);
            }

            return redirect()->back()->with('success', 'Cart added!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            Log::error('Request data that failed validation: ' . json_encode($request->all()));

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', array_map(function($errors) {
                        return implode(', ', $errors);
                    }, $e->errors())),
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error saving cart item: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add item to cart: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to add item to cart');
        }
    }

    public function showCart()
    {
        $sessionId = Session::getId();
        $cartItems = Cart::where('session_id', $sessionId)->get();

        return view('client.partials.cart', compact('cartItems'));
    }

    public function remove(Request $request)
    {
        try {
            $cartId = $request->input('cart_id');
            $sessionId = Session::getId();

            \Log::info('Attempting to remove cart item', [
                'cart_id' => $cartId,
                'session_id' => $sessionId
            ]);

            // Find and delete the cart item
            $cartItem = Cart::where('id', $cartId)
                ->where('session_id', $sessionId)
                ->first();

            if ($cartItem) {
                \Log::info('Found cart item to delete', [
                    'cart_id' => $cartId,
                    'pack_type' => $cartItem->pack_type
                ]);

                $cartItem->delete();
                \Log::info('Successfully deleted cart item');

                return response()->json(['success' => true]);
            }

            \Log::warning('Cart item not found', [
                'cart_id' => $cartId,
                'session_id' => $sessionId
            ]);

            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        } catch (\Exception $e) {
            \Log::error('Error removing cart item: ' . $e->getMessage(), [
                'cart_id' => $request->input('cart_id'),
                'session_id' => Session::getId(),
                'exception' => $e
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to remove item'], 500);
        }
    }
}
