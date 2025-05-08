<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Session;

class PickupController extends Controller
{
    /**
     * Show the pack menu page for pickup orders
     */
    public function packMenu()
    {
        // Mark this as a pickup order in the session
        Session::put('order_type', 'pickup');
        return redirect()->route('pickup.menu');
    }

    /**
     * Show the pack menu page for pickup orders
     */
    public function showPackMenu()
    {
        // Ensure order type is set to pickup
        Session::put('order_type', 'pickup');
        $sectors = \App\Models\Sector::all();
        return view('client.modules.packs-page', compact('sectors'));
    }

    /**
     * Select a time slot for pickup
     */
    public function selectTimeSlot(Request $request)
    {
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'time_slot' => 'required|string',
            'time_slot_label' => 'required|string',
        ]);

        // Store the selected time slot in the session
        Session::put('selected_time_slot', [
            'date' => $request->date,
            'time' => $request->time_slot,
            'label' => $request->time_slot_label
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Time slot selected successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Time slot selected successfully');
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

    /**
     * Show the time selection page for pickup orders
     */
    public function showTimeSelection()
    {
        // Mark this as a pickup order in the session
        Session::put('order_type', 'pickup');

        return view('client.modules.pickup-time-selection');
    }
}
