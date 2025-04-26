@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">

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

    <div class="row">
        <!-- Order Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-shopping-cart me-1"></i>
                        Order Items
                    </div>
                    <div>
                        <span class="badge bg-{{
                            $order->status == 'completed' ? 'success' :
                            ($order->status == 'processing' ? 'primary' :
                            ($order->status == 'cancelled' ? 'danger' : 'warning'))
                        }} fs-6">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light me-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name ?? 'Product Not Available' }}</h6>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">PKR.{{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">PKR.{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal:</th>
                                    <th class="text-end">PKR.{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">PKR.{{ number_format($order->total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-sticky-note me-1"></i>
                    Order Notes
                </div>
                <div class="card-body">
                    @if($order->delivery_notes)
                        <p>{{ $order->delivery_notes }}</p>
                    @else
                        <p class="text-muted">No notes for this order.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Order Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Order Actions
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="payment_status" name="payment_status" value="1" {{ $order->payment_status ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_status">Mark as Paid</label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Order
                            </button>
                        </div>
                    </form>

                    <hr>

                    <div class="d-grid">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOrderModal">
                            <i class="fas fa-trash me-1"></i> Delete Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Customer Information
                </div>
                <div class="card-body">
                    <h6>Customer Details</h6>
                    <p class="mb-0"><strong>Name:</strong> {{ $order->name ?? 'Guest' }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>


                    <hr>

                    <h6>Order Details</h6>
                    <p class="mb-0"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    <p class="mb-0">
                        <strong>Time Slot:</strong>
                        @if($order->timeSlot)
                            {{ $order->timeSlot->start_time }} - {{ $order->timeSlot->end_time }}
                        @else
                            N/A
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong>Payment Method:</strong>
                        {{ ucfirst($order->payment_method ?? 'N/A') }}
                    </p>
                    <p class="mb-0">
                        <strong>Payment Status:</strong>
                        <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                            {{ $order->payment_status ? 'Paid' : 'Pending' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Order Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete Order #{{ $order->id }}? This action cannot be undone.</p>
                <p><strong>Warning:</strong> All order items and related data will be permanently deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Fix modal overlay issue */
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

    @media print {
        .sidebar, .topnav, .breadcrumb, .btn, .alert, form, .modal, .card-header {
            display: none !important;
        }
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .card {
            border: none !important;
        }
        .card-body {
            padding: 0 !important;
        }

        body {
            font-size: 12pt;
        }
        h1 {
            font-size: 16pt;
            margin-bottom: 20px;
        }
    }
</style>
@endsection
