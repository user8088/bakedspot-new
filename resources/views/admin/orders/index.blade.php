@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-shopping-cart me-1"></i>
                All Orders
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.time_slots.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-clock me-1"></i> Manage Time Slots
                </a>
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.orders.report') }}" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> Generate Report
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- @if(session('success'))
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
            @endif --}}

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
                                    {{ $order->timeSlot->start_time }} - {{ $order->timeSlot->end_time }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>PKR.{{ number_format($order->total, 2) }}</td>
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
                                <div class="small text-muted">
                                    @if($order->payment_method === 'pickup')
                                        Payment on Pickup
                                    @else
                                        Cash on Delivery
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $order->id }}" aria-hidden="true" data-bs-backdrop="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $order->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete Order #{{ $order->id }}? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="all" @if(request('status') == 'all') selected @endif>All</option>
                            <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                            <option value="processing" @if(request('status') == 'processing') selected @endif>Processing</option>
                            <option value="completed" @if(request('status') == 'completed') selected @endif>Completed</option>
                            <option value="cancelled" @if(request('status') == 'cancelled') selected @endif>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="mb-3">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
