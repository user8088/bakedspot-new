<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'interval_minutes',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Ensure start time is properly formatted.
     *
     * @param  string  $value
     * @return void
     */
    public function setStartTimeAttribute($value)
    {
        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $value)) {
            $this->attributes['start_time'] = $value;
        } elseif (strtotime($value)) {
            // If it's another format that PHP can parse, convert it to H:i
            $this->attributes['start_time'] = date('H:i', strtotime($value));
        } else {
            // If unparseable, keep the original value (validation will catch this)
            $this->attributes['start_time'] = $value;
        }
    }

    /**
     * Ensure end time is properly formatted.
     *
     * @param  string  $value
     * @return void
     */
    public function setEndTimeAttribute($value)
    {
        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $value)) {
            $this->attributes['end_time'] = $value;
        } elseif (strtotime($value)) {
            // If it's another format that PHP can parse, convert it to H:i
            $this->attributes['end_time'] = date('H:i', strtotime($value));
        } else {
            // If unparseable, keep the original value (validation will catch this)
            $this->attributes['end_time'] = $value;
        }
    }

    /**
     * Get orders that belong to this time slot.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Generate available time slots for a given date
     *
     * @param string $date Format: Y-m-d
     * @return array
     */
    public static function generateAvailableTimeSlots(string $date)
    {
        $settings = self::first() ?? new self();

        $startTime = strtotime($settings->start_time);
        $endTime = strtotime($settings->end_time);
        $interval = $settings->interval_minutes * 60; // Convert to seconds

        $currentTime = time();
        $selectedDate = strtotime($date);
        $isToday = date('Y-m-d', $currentTime) === $date;

        $slots = [];

        for ($time = $startTime; $time <= $endTime - $interval; $time += $interval) {
            $slotTime = strtotime($date . ' ' . date('H:i:s', $time));

            // If it's today and the slot time has already passed, skip it
            if ($isToday && $slotTime <= $currentTime) {
                continue;
            }

            $slots[] = [
                'value' => date('H:i', $time),
                'label' => date('h:i A', $time),
                'timestamp' => $slotTime,
            ];
        }

        return $slots;
    }
}
