@extends('admin.layouts.app')

@section('title', 'Time Slot Management')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Time Slot Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">Time Slots</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clock me-1"></i>
                    Time Slot Settings
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.time_slots.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="interval_minutes" class="form-label">Time Slot Interval (minutes)</label>
                            <input type="number" class="form-control" id="interval_minutes" name="interval_minutes"
                                value="{{ old('interval_minutes', $timeSlot->interval_minutes) }}"
                                min="10" max="120" required>
                            <div class="form-text">
                                Set the duration of each time slot (between 10 and 120 minutes).
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Daily Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time"
                                    value="{{ old('start_time', substr($timeSlot->start_time, 0, 5)) }}" required>
                                <div class="form-text">
                                    When time slots should start each day.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">Daily End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time"
                                    value="{{ old('end_time', substr($timeSlot->end_time, 0, 5)) }}" required>
                                <div class="form-text">
                                    When time slots should end each day.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="active" name="active"
                                {{ old('active', $timeSlot->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                            <div class="form-text">
                                Enable or disable time slot booking.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Settings
                            </button>
                            <a href="{{ route('admin.time_slots.preview') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-eye me-1"></i> Preview Time Slots
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    How Time Slots Work
                </div>
                <div class="card-body">
                    <h5>Time Slot Configuration</h5>
                    <p>These settings control how time slots are generated for pickup orders. Here's how it works:</p>
                    <ul>
                        <li><strong>Interval:</strong> This determines the length of each time slot. For example, if set to 30 minutes, slots will be 8:00-8:30, 8:30-9:00, etc.</li>
                        <li><strong>Start/End Time:</strong> These define the daily operating hours when orders can be picked up.</li>
                        <li><strong>Active:</strong> If disabled, customers won't be able to select time slots during checkout.</li>
                    </ul>

                    <h5 class="mt-4">Time Slot Display</h5>
                    <p>For a customer selecting a pickup time slot:</p>
                    <ul>
                        <li>Only future time slots will be shown (past slots are automatically filtered out).</li>
                        <li>For same-day orders, only time slots after the current time will be available.</li>
                        <li>Time slots are generated dynamically based on these settings.</li>
                    </ul>

                    <div class="alert alert-info">
                        <strong>Example:</strong> If interval is 20 minutes with operating hours 8:00 AM to 10:00 PM, slots would be:
                        8:00-8:20, 8:20-8:40, 8:40-9:00, and so on.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
