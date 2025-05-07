<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function start_order(){
        return view('client.modules.order-location');
    }

    public function showCheckout()
    {
        // Get available time slots for today
        $date = date('Y-m-d');
        $timeSlots = TimeSlot::generateAvailableTimeSlots($date);

        return view('client.modules.checkout', compact('timeSlots', 'date'));
    }

    /**
     * Get time slots for a specific date via AJAX
     */
    public function getTimeSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
        ]);

        $timeSlots = TimeSlot::generateAvailableTimeSlots($request->date);
        return response()->json($timeSlots);
    }

    public function processCheckout(Request $request)
    {
        // Validate the request
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'zip' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod',
            'delivery_type' => 'required|in:delivery,pickup',
            'time_slot' => 'nullable|string',
            'pickup_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            Log::warning('Checkout validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            // Get cart items
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('get-packmenupage')
                    ->with('error', 'Your cart is empty. Please add items to your cart before checkout.');
            }

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $deliveryCharges = 0;
            $sectorId = null;

            // Handle delivery vs pickup
            if ($validated['delivery_type'] === 'delivery') {
                // Get selected sector/delivery area
                $selectedSector = session('selected_sector');
                if (!$selectedSector) {
                    return redirect()->route('get-packmenupage')
                        ->with('error', 'Please select a delivery area before checkout.');
                }

                $deliveryCharges = $selectedSector['delivery_charges'];
                $sectorId = $selectedSector['id'];
            } else {
                // For pickup, no delivery charge
                $deliveryCharges = 0;

                // Use placeholders for address fields
                if ($validated['address'] === 'Pickup') {
                    $validated['address'] = 'In-store pickup';
                    $validated['city'] = 'In-store pickup';
                    $validated['area'] = 'In-store pickup';
                }
            }

            $total = $subtotal + $deliveryCharges;

            // Get or create time slot for pickup
            $timeSlotId = null;
            $selectedTimeSlot = null;

            if ($validated['delivery_type'] === 'pickup') {
                // Try to get time slot from the form submission first
                if (!empty($validated['time_slot'])) {
                    $timeSlot = $validated['time_slot'];
                    $pickupDate = $validated['pickup_date'];
                }
                // If not found in the form, try to get from session
                else if (Session::has('selected_time_slot')) {
                    $selectedTimeSlot = Session::get('selected_time_slot');
                    $timeSlot = $selectedTimeSlot['time'];
                    $pickupDate = $selectedTimeSlot['date'];
                }
                // If neither exists, return error
                else {
                    return redirect()->back()
                        ->with('error', 'Please select a pickup time.')
                        ->withInput();
                }

                // Get the time slot settings
                $timeSlotSettings = TimeSlot::first();
                if (!$timeSlotSettings) {
                    return redirect()->back()
                        ->with('error', 'Time slots are not configured properly. Please contact support.')
                        ->withInput();
                }

                // Save the time slot ID
                $timeSlotId = $timeSlotSettings->id;
            }

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
                'payment_method' => $validated['delivery_type'] === 'pickup' ? 'pickup' : $validated['payment_method'],
                'payment_status' => false, // Set payment status as unpaid for COD
                'sector_id' => $sectorId,
                'time_slot_id' => $timeSlotId,
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

            // Clear selected sector and time slot
            Session::forget('selected_sector');
            Session::forget('selected_time_slot');
            Session::forget('order_type');

            // Redirect to thank you page
            return redirect()->route('checkout.success', ['order_id' => $order->id])
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage(), [
                'stacktrace' => $e->getTraceAsString()
            ]);
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
