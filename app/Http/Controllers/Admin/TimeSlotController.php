<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeSlotController extends Controller
{
    /**
     * Display time slot settings form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeSlot = TimeSlot::first() ?: new TimeSlot();
        return view('admin.modules.time_slots', compact('timeSlot'));
    }

    /**
     * Update the time slot settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = [
            'start_time.required' => 'Please enter an opening time.',
            'start_time.date_format' => 'Opening time must be in 24-hour format (HH:MM).',
            'end_time.required' => 'Please enter a closing time.',
            'end_time.date_format' => 'Closing time must be in 24-hour format (HH:MM).',
            'end_time.after' => 'Closing time must be after opening time.',
            'interval_minutes.required' => 'Please select a time slot interval.',
            'interval_minutes.integer' => 'Time slot interval must be a number.',
            'interval_minutes.min' => 'Time slot interval must be at least 10 minutes.',
            'interval_minutes.max' => 'Time slot interval must not exceed 120 minutes.',
        ];

        $validated = $request->validate([
            'interval_minutes' => 'required|integer|min:10|max:120',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], $messages);

        try {
            $timeSlot = TimeSlot::first();

            if (!$timeSlot) {
                $timeSlot = new TimeSlot();
            }

            $timeSlot->interval_minutes = $validated['interval_minutes'];
            $timeSlot->start_time = $validated['start_time'];
            $timeSlot->end_time = $validated['end_time'];
            $timeSlot->active = $request->has('active');
            $timeSlot->save();

            return redirect()->route('admin.time_slots.index')
                ->with('success', 'Time slot settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.time_slots.index')
                ->with('error', 'Error saving time slot settings: ' . $e->getMessage());
        }
    }

    /**
     * Generate a preview of time slots for testing purposes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        // Get the global time slot settings
        $settings = TimeSlot::first();

        if (!$settings) {
            return redirect()->route('admin.time_slots.index')
                ->with('error', 'Please configure time slot settings first');
        }

        // Generate slots based on settings
        $slots = $this->generateTimeSlots($date, $settings);

        return view('admin.modules.time_slots_preview', compact('slots', 'date'));
    }

    /**
     * Generate time slots for a specific date based on settings.
     *
     * @param  string  $date
     * @param  \App\Models\TimeSlot  $settings
     * @return array
     */
    private function generateTimeSlots($date, $settings)
    {
        $slots = [];
        $now = Carbon::now();
        $startTime = Carbon::parse($date . ' ' . $settings->start_time);
        $endTime = Carbon::parse($date . ' ' . $settings->end_time);
        $intervalMinutes = $settings->interval_minutes;

        $current = clone $startTime;

        while ($current < $endTime) {
            $slotEndTime = (clone $current)->addMinutes($intervalMinutes);

            // Ensure the slot end time doesn't exceed the overall end time
            if ($slotEndTime > $endTime) {
                $slotEndTime = clone $endTime;
            }

            // Check if slot is in the past
            $isPast = $current < $now;

            // In a real system, you'd check bookings table to see if slot is taken
            // For demo purposes, we'll randomly mark some as not available
            $isBooked = rand(0, 10) > 8; // 20% chance it's booked

            $slots[] = [
                'start_time' => $current->format('H:i'),
                'end_time' => $slotEndTime->format('H:i'),
                'available' => !$isPast && !$isBooked,
                'past' => $isPast,
                'booked' => $isBooked
            ];

            $current->addMinutes($intervalMinutes);
        }

        return $slots;
    }
}
