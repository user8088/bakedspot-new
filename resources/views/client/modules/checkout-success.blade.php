@extends('client.layouts.main')
@section('page')
<div class="success-container py-5">
    <div class="container">
        <div class="success-box">
            <div class="success-icon mb-4">
                <i class="fas fa-check-circle"></i>
            </div>

            <h1 class="heading-black-small mb-3">Order Confirmed!</h1>
            <p class="mb-4">Thank you for your order. We'll contact you shortly to confirm delivery details.</p>

            <div class="order-details mb-4">
                <h2 class="section-title">Order #{{ $order->id }}</h2>
                <div class="order-info p-3 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5>Delivery Details</h5>
                            <p class="mb-1">{{ $order->name }}</p>
                            <p class="mb-1">{{ $order->phone }}</p>
                            <p class="mb-1">{{ $order->email }}</p>
                            <p class="mb-1">{{ $order->address }}</p>
                            @if($order->sector_id)
                                <p class="mb-0">{{ $order->city }}, {{ $order->area }}</p>
                            {{-- @elseif($order->time_slot_id)
                                <p class="mb-0">Pickup Time:</p> --}}
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Payment Information</h5>
                            <p class="mb-1">
                                Method:
                                @if($order->sector_id)
                                    Cash on Delivery
                                @elseif($order->time_slot_id)
                                    Payment on Pickup
                                @else
                                    Cash on Delivery
                                @endif
                            </p>
                            <p class="mb-1">Status: {{ ucfirst($order->status) }}</p>
                            <p class="mb-0">Total: PKR {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Order Summary</h2>
                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item d-flex align-items-center border-bottom py-3">
                        <img src="{{ asset('images/pk-4.png') }}" class="item-image" alt="{{ $item->pack_type }}">
                        <div class="item-details ms-3">
                            <h5 class="item-title">{{ $item->pack_type }}</h5>
                            <p class="item-price mb-0">PKR {{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                    @endforeach

                    <div class="costs-breakdown mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>PKR {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            @if($order->sector_id)
                                <span>Delivery Charges:</span>
                                <span>PKR {{ number_format($order->delivery_charges, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-3 pt-3 border-top">
                            <span>Total:</span>
                            <span>PKR {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <p>You will receive an email confirmation shortly at <strong>{{ $order->email }}</strong></p>
                <p class="text-note">Please make sure you have online payment ready upon delivery.</p>
            </div>

            <div class="text-center">
                <a href="{{ route('get-homepage') }}" class="btn btn-outline-dark me-2">Return Home</a>
                <a href="{{ route('get-packmenupage') }}" class="btn btn-main">Order Again</a>
            </div>
        </div>
    </div>
</div>

<style>
    .success-container {
        background-color: #f9f9f9;
        min-height: 80vh;
    }

    .success-box {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        max-width: 800px;
        margin: 0 auto;
    }

    .success-icon {
        text-align: center;
        font-size: 60px;
        color: #28a745;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        font-family: 'Bakedspot-Bold';
    }

    .order-info {
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .order-items {
        margin-top: 20px;
    }

    .item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .costs-breakdown {
        color: #555;
    }

    .text-note {
        font-size: 0.9rem;
        color: #dc3545;
    }

    @media (max-width: 767px) {
        .success-box {
            padding: 20px;
        }
    }
</style>
@endsection
