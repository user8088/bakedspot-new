@extends('client.layouts.main')
@section('page')
<div class="checkout-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1 class="heading-black-small mb-4">Checkout</h1>

                <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    <!-- Contact Information -->
                    <div class="checkout-section mb-4">
                        <h2 class="section-title">Contact Information</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="checkout-section mb-4">
                        <h2 class="section-title">Delivery Address</h2>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">Area</label>
                                <input type="text" class="form-control" id="area" name="area" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="zip" name="zip">
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Notes -->
                    <div class="checkout-section mb-4">
                        <h2 class="section-title">Delivery Notes</h2>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">Special Instructions (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Special instructions for delivery"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-section mb-4">
                        <h2 class="section-title">Payment Method</h2>
                        <div class="payment-option">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery
                                </label>
                                <div class="payment-description">
                                    <small class="text-muted">Pay with cash when your order is delivered.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-5">
                <!-- Order Summary -->
                <div class="order-summary">
                    <h2 class="section-title">Order Summary</h2>

                    <div class="order-items">
                        @php
                            $sessionId = Session::getId();
                            $cartItems = \App\Models\Cart::where('session_id', $sessionId)->get();
                            $subtotal = $cartItems->sum('total_price');
                            $selectedSector = session('selected_sector');
                            $deliveryCharges = $selectedSector ? $selectedSector['delivery_charges'] : 0;
                            $total = $subtotal + $deliveryCharges;
                        @endphp

                        @if($cartItems->isEmpty())
                            <div class="text-center py-4">
                                <p>Your bag is empty.</p>
                                <a href="{{ route('get-packmenupage') }}" class="btn btn-outline-dark mt-3">Order Now</a>
                            </div>
                        @else
                            @foreach($cartItems as $item)
                            <div class="order-item d-flex align-items-center border-bottom py-3">
                                <img src="{{ asset('images/pk-4.png') }}" class="item-image" alt="{{ $item->pack_type }}">
                                <div class="item-details ms-3">
                                    <h5 class="item-title">{{ $item->pack_type }}</h5>
                                    <p class="item-price mb-0">PKR {{ number_format($item->total_price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach

                            <!-- Costs Breakdown -->
                            <div class="costs-breakdown mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>PKR {{ number_format($subtotal, 2) }}</span>
                                </div>

                                @if($selectedSector)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Delivery to {{ $selectedSector['name'] }}:</span>
                                    <span>PKR {{ number_format($deliveryCharges, 2) }}</span>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between fw-bold fs-5 mt-3 pt-3 border-top">
                                    <span>Total:</span>
                                    <span>PKR {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <div class="mt-4">
                                <button type="submit" form="checkout-form" class="btn btn-main w-100 py-3">Place Order</button>
                                <div class="text-center mt-3">
                                    <small class="text-muted">By placing your order, you agree to our <a href="#">Terms and Conditions</a>.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-container {
        background-color: #f9f9f9;
        min-height: 80vh;
    }

    .checkout-section {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        font-family: 'Bakedspot-Bold';
    }

    .order-summary {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        position: sticky;
        top: 100px;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #FFB9CD;
        box-shadow: 0 0 0 0.25rem rgba(255, 185, 205, 0.25);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
    }

    .payment-option {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
    }

    .payment-description {
        margin-left: 24px;
        margin-top: 5px;
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

    @media (max-width: 991px) {
        .order-summary {
            margin-top: 30px;
            position: static;
        }
    }
</style>
@endsection
