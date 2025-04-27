@extends('admin.layouts.main')

@section('page')
<div class="col-lg-10 col-12 ps-lg-5 pt-3 p-3">

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
                                    <th>Pack</th>
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
                                            @php
                                                $packImage = 'images/pk-4.png';
                                                if (strpos($item->pack_type, '8') !== false) {
                                                    $packImage = 'images/pk-8.png';
                                                }
                                            @endphp
                                            <img src="{{ asset($packImage) }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $item->pack_type }}">
                                            <div>
                                                <h6 class="mb-0">{{ $item->pack_type }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">PKR.{{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">PKR.{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-light">
                                        <div class="small">
                                            <strong>Pack Items:</strong>
                                            <ul class="list-unstyled mb-0 ps-3 pt-1">
                                                @php
                                                    $productDetails = [];
                                                    if($item->item_1) {
                                                        $product1 = App\Models\Product::with('images')->find($item->item_1);
                                                        if($product1) {
                                                            $productDetails[] = [
                                                                'name' => $product1->name,
                                                                'image' => $product1->images->isNotEmpty() ? $product1->images->first()->pack_image_url : null,
                                                                'id' => $product1->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_1,
                                                                'image' => null,
                                                                'id' => $item->item_1
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_2) {
                                                        $product2 = App\Models\Product::with('images')->find($item->item_2);
                                                        if($product2) {
                                                            $productDetails[] = [
                                                                'name' => $product2->name,
                                                                'image' => $product2->images->isNotEmpty() ? $product2->images->first()->pack_image_url : null,
                                                                'id' => $product2->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_2,
                                                                'image' => null,
                                                                'id' => $item->item_2
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_3) {
                                                        $product3 = App\Models\Product::with('images')->find($item->item_3);
                                                        if($product3) {
                                                            $productDetails[] = [
                                                                'name' => $product3->name,
                                                                'image' => $product3->images->isNotEmpty() ? $product3->images->first()->pack_image_url : null,
                                                                'id' => $product3->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_3,
                                                                'image' => null,
                                                                'id' => $item->item_3
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_4) {
                                                        $product4 = App\Models\Product::with('images')->find($item->item_4);
                                                        if($product4) {
                                                            $productDetails[] = [
                                                                'name' => $product4->name,
                                                                'image' => $product4->images->isNotEmpty() ? $product4->images->first()->pack_image_url : null,
                                                                'id' => $product4->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_4,
                                                                'image' => null,
                                                                'id' => $item->item_4
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_5) {
                                                        $product5 = App\Models\Product::with('images')->find($item->item_5);
                                                        if($product5) {
                                                            $productDetails[] = [
                                                                'name' => $product5->name,
                                                                'image' => $product5->images->isNotEmpty() ? $product5->images->first()->pack_image_url : null,
                                                                'id' => $product5->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_5,
                                                                'image' => null,
                                                                'id' => $item->item_5
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_6) {
                                                        $product6 = App\Models\Product::with('images')->find($item->item_6);
                                                        if($product6) {
                                                            $productDetails[] = [
                                                                'name' => $product6->name,
                                                                'image' => $product6->images->isNotEmpty() ? $product6->images->first()->pack_image_url : null,
                                                                'id' => $product6->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_6,
                                                                'image' => null,
                                                                'id' => $item->item_6
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_7) {
                                                        $product7 = App\Models\Product::with('images')->find($item->item_7);
                                                        if($product7) {
                                                            $productDetails[] = [
                                                                'name' => $product7->name,
                                                                'image' => $product7->images->isNotEmpty() ? $product7->images->first()->pack_image_url : null,
                                                                'id' => $product7->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_7,
                                                                'image' => null,
                                                                'id' => $item->item_7
                                                            ];
                                                        }
                                                    }
                                                    if($item->item_8) {
                                                        $product8 = App\Models\Product::with('images')->find($item->item_8);
                                                        if($product8) {
                                                            $productDetails[] = [
                                                                'name' => $product8->name,
                                                                'image' => $product8->images->isNotEmpty() ? $product8->images->first()->pack_image_url : null,
                                                                'id' => $product8->id
                                                            ];
                                                        } else {
                                                            $productDetails[] = [
                                                                'name' => 'Product #' . $item->item_8,
                                                                'image' => null,
                                                                'id' => $item->item_8
                                                            ];
                                                        }
                                                    }
                                                @endphp

                                                @foreach($productDetails as $product)
                                                    <li class="mb-2 d-flex align-items-center">
                                                        @if($product['image'])
                                                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <span style="font-size: 14px;">{{ $product['name'] }}</span>
                                                    </li>
                                                @endforeach

                                                @if(empty($productDetails))
                                                    <li style="font-size: 14px;">No pack items specified</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
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
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true" data-bs-backdrop="false">
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
