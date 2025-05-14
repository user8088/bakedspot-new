@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clock me-1"></i>
                Configure Time Slots
            </div>
            <div>
                <a href="{{ route('admin.time_slots.preview') }}?date={{ date('Y-m-d') }}" class="btn btn-sm btn-main">
                    <i class="fas fa-eye me-1"></i> Preview Time Slots
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('admin.time_slots.update') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Time Slot Configuration</h5>
                            </div>
                            <div class="card-body">
                                {{-- <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="active" name="active" {{ isset($timeSlot) && $timeSlot->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Enable Time Slots</label>
                                    </div>
                                    <small class="text-muted">When disabled, customers won't be asked to select a time slot</small>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="interval_minutes" class="form-label">Time Slot Interval (minutes)</label>
                                    <select class="form-select @error('interval_minutes') is-invalid @enderror" id="interval_minutes" name="interval_minutes">
                                        <option value="15" {{ isset($timeSlot) && $timeSlot->interval_minutes == 15 ? 'selected' : '' }}>15 minutes</option>
                                        <option value="30" {{ isset($timeSlot) && $timeSlot->interval_minutes == 30 ? 'selected' : '' }}>30 minutes</option>
                                        <option value="60" {{ isset($timeSlot) && $timeSlot->interval_minutes == 60 ? 'selected' : '' }}>1 hour</option>
                                        <option value="120" {{ isset($timeSlot) && $timeSlot->interval_minutes == 120 ? 'selected' : '' }}>2 hours</option>
                                    </select>
                                    <small class="text-muted">How long each time slot should be</small>
                                    @error('interval_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Opening Time</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-select" id="start_hour" name="start_hour">
                                                @php
                                                    $currentStartHour = isset($timeSlot) ? (int)substr($timeSlot->start_time, 0, 2) : 9;
                                                @endphp
                                                @for($i = 0; $i < 24; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $currentStartHour == $i ? 'selected' : '' }}>
                                                        {{ $i == 0 ? '12' : ($i > 12 ? $i - 12 : $i) }}:00 {{ $i < 12 ? 'AM' : 'PM' }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <input type="hidden" name="start_time" id="start_time_input" value="{{ isset($timeSlot) ? $timeSlot->start_time : '09:00' }}">
                                    </div>
                                    <small class="text-muted">When your business opens</small>
                                    @error('start_time')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Closing Time</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-select" id="end_hour" name="end_hour">
                                                @php
                                                    $currentEndHour = isset($timeSlot) ? (int)substr($timeSlot->end_time, 0, 2) : 18;
                                                @endphp
                                                @for($i = 0; $i < 24; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $currentEndHour == $i ? 'selected' : '' }}>
                                                        {{ $i == 0 ? '12' : ($i > 12 ? $i - 12 : $i) }}:00 {{ $i < 12 ? 'AM' : 'PM' }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <input type="hidden" name="end_time" id="end_time_input" value="{{ isset($timeSlot) ? $timeSlot->end_time : '18:00' }}">
                                    </div>
                                    <small class="text-muted">When your business closes</small>
                                    @error('end_time')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Information</h5>
                            </div>
                            <div class="card-body">
                                <p>
                                    <i class="fas fa-info-circle text-info me-2"></i>
                                    Configure the time slots for customer order pickups. Customers will be able to select from available time slots during checkout.
                                </p>
                                <ul class="text-muted mb-0">
                                    <li style="font-size: 14px;">Set the opening and closing times for your business</li>
                                    <li style="font-size: 14px;">Choose the interval between each time slot</li>
                                    <li style="font-size: 14px;">Enable or disable the time slot selection feature</li>
                                    <li style="font-size: 14px;">You can preview how the time slots will appear to customers</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-main">
                        <i class="fas fa-save me-1"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Fix modal overlay issue in case modals are added later */
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }

    /* Make sure the modal only covers its own content */
    .modal-dialog {
        margin: 1.75rem auto;
        max-width: 500px;
        pointer-events: all;
    }

    /* Hide extra backdrop if multiple modals are opened */
    .modal-backdrop + .modal-backdrop {
        display: none;
    }

    /* Style for time selectors */
    .form-select {
        cursor: pointer;
    }

    .invalid-feedback.d-block {
        display: block !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update hidden time inputs
        function updateTimeInputs() {
            const startHour = document.getElementById('start_hour').value;
            document.getElementById('start_time_input').value = `${startHour}:00`;

            const endHour = document.getElementById('end_hour').value;
            document.getElementById('end_time_input').value = `${endHour}:00`;
        }

        // Add event listeners to all time selectors
        document.getElementById('start_hour').addEventListener('change', updateTimeInputs);
        document.getElementById('end_hour').addEventListener('change', updateTimeInputs);

        // Initialize time inputs on page load
        updateTimeInputs();
    });
</script>
@endsection
