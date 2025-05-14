@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                Time Slots for {{ date('F j, Y', strtotime($date)) }}
            </div>
            <div>
                <a href="{{ route('admin.time_slots.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Settings
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.time_slots.preview') }}" method="GET" class="d-flex">
                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                        <button type="submit" class="btn btn-main ms-2">Show</button>
                    </form>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                This is a preview of how time slots will appear to customers for the selected date. Time slots that are in the past will be disabled.
            </div>

            <div class="row mt-4">
                @php
                    $now = new DateTime('now', new DateTimeZone('Asia/Karachi'));
                    $currentTime = $now->format('H:i');
                    $today = $now->format('Y-m-d');
                    $isToday = ($date === $today);
                @endphp

                @if(count($slots) > 0)
                    @foreach($slots as $slot)
                        @php
                            // Check if slot is in the past for today
                            $isPast = $isToday && $slot['start_time'] < $currentTime;

                            // Convert times to 12-hour format
                            $startTime12h = date('h:i A', strtotime($slot['start_time']));
                            $endTime12h = date('h:i A', strtotime($slot['end_time']));

                            // Override the available status for past slots
                            if ($isPast) {
                                $slot['past'] = true;
                            }
                        @endphp
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card h-100 {{ $isPast ? 'bg-light' : '' }}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $startTime12h }} - {{ $endTime12h }}</h5>
                                    <p class="card-text">
                                        @if($isPast)
                                            <span class="badge bg-secondary">Past</span>
                                        @else
                                            <span class="badge bg-success">Available</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-warning">
                            No time slots available for this date. Please check your time slot configuration.
                        </div>
                    </div>
                @endif
            </div>
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
</style>
@endsection
