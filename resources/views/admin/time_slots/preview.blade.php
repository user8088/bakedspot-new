@extends('admin.layouts.app')

@section('title', 'Time Slot Preview')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Time Slot Preview</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.time_slots.index') }}">Time Slots</a></li>
        <li class="breadcrumb-item active">Preview</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                Preview for {{ date('F d, Y', strtotime($date)) }}
            </div>
            <div class="d-flex align-items-center">
                <form action="{{ route('admin.time_slots.preview') }}" method="GET" class="d-flex">
                    <input type="date" class="form-control form-control-sm me-2" name="date" value="{{ $date }}" required>
                    <button type="submit" class="btn btn-sm btn-primary">Show</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(count($slots) > 0)
                <div class="row">
                    @foreach($slots as $slot)
                        <div class="col-md-3 col-sm-4 col-6 mb-3">
                            <div class="card">
                                <div class="card-body p-3 text-center">
                                    <h5 class="card-title mb-0">{{ $slot['label'] }}</h5>
                                    <p class="card-text small text-muted">
                                        {{ date('h:i A', $slot['timestamp'] + (30 * 60)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 text-muted">
                    <p>Total available time slots: <strong>{{ count($slots) }}</strong></p>
                </div>
            @else
                <div class="alert alert-warning">
                    <h5 class="alert-heading">No Time Slots Available!</h5>
                    <p>There are no available time slots for this date. This could be due to:</p>
                    <ul>
                        <li>All time slots today have already passed</li>
                        <li>Time slots are not configured properly</li>
                    </ul>
                    <hr>
                    <p class="mb-0">Try selecting a future date or check your time slot configuration.</p>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.time_slots.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Settings
            </a>
        </div>
    </div>
</div>
@endsection
