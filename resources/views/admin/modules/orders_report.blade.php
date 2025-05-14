@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-chart-bar me-1"></i>
                Orders Summary ({{ $start_date }} to {{ $end_date }})
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.report') }}?start_date={{ $start_date }}&end_date={{ $end_date }}&status={{ $status }}&download=pdf" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> Download PDF
                </a>
                {{-- <a href="{{ route('admin.orders.report') }}?start_date={{ $start_date }}&end_date={{ $end_date }}&status={{ $status }}&format=csv" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-file-csv me-1"></i> Download CSV
                </a> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('admin.orders.report') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $start_date }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $end_date }}">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" @if($status == 'all') selected @endif>All</option>
                                <option value="pending" @if($status == 'pending') selected @endif>Pending</option>
                                <option value="processing" @if($status == 'processing') selected @endif>Processing</option>
                                <option value="completed" @if($status == 'completed') selected @endif>Completed</option>
                                <option value="cancelled" @if($status == 'cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="all" @if(request('payment_method') == 'all') selected @endif>All</option>
                                <option value="cod" @if(request('payment_method') == 'cod') selected @endif>Cash on Delivery</option>
                                <option value="pickup" @if(request('payment_method') == 'pickup') selected @endif>Payment on Pickup</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="all" @if(request('payment_status') == 'all') selected @endif>All</option>
                                <option value="1" @if(request('payment_status') == '1') selected @endif>Paid</option>
                                <option value="0" @if(request('payment_status') == '0') selected @endif>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="display-4">{{ $totalOrders }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>
                                <p class="display-4">PKR.{{ number_format($totalRevenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5>Orders by Status</h5>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Pending</h6>
                                    <p class="mb-0 display-5">{{ $ordersByStatus['pending'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Processing</h6>
                                    <p class="mb-0 display-5">{{ $ordersByStatus['processing'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Completed</h6>
                                    <p class="mb-0 display-5">{{ $ordersByStatus['completed'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Cancelled</h6>
                                    <p class="mb-0 display-5">{{ $ordersByStatus['cancelled'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </td>
                            <td>
                                {{ $order->name ?? 'Guest' }}
                                <div class="small text-muted">{{ $order->email ?? 'No email' }}</div>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($order->timeSlot)
                                    {{ date('h:i A', strtotime($order->timeSlot->start_time)) }} - {{ date('h:i A', strtotime($order->timeSlot->end_time)) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>PKR {{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{
                                    $order->status == 'completed' ? 'success' :
                                    ($order->status == 'processing' ? 'primary' :
                                    ($order->status == 'cancelled' ? 'danger' : 'warning'))
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                                    {{ $order->payment_status ? 'Paid' : 'Pending' }}
                                </span>
                                <div class="text-muted">
                                    @if($order->payment_method === 'pickup')
                                        Payment on Pickup
                                    @else
                                        Cash on Delivery
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found matching the criteria</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
