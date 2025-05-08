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

                    <!-- Delivery Options -->
                    <div class="checkout-section mb-4">
                        <h2 class="section-title">Order Type</h2>
                        <div class="row mb-3">
                            <div class="col-12">
                                @php
                                    $orderType = Session::get('order_type', 'delivery');
                                @endphp
                                <input type="hidden" name="delivery_type" value="{{ $orderType }}">
                                <div class="delivery-type-display">
                                    <span class="text-capitalize">{{ $orderType }}</span>
                                </div>
                            </div>
                        </div>

                        <div id="pickup-options" class="row" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date</label>
                                <input type="date" class="form-control" id="pickup_date" name="pickup_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ Session::get('selected_time_slot.date', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="time_slot" class="form-label">Pickup Time</label>
                                <select class="form-control" id="time_slot" name="time_slot">
                                    @if(Session::has('selected_time_slot'))
                                        <option value="{{ Session::get('selected_time_slot.time') }}">
                                            {{ Session::get('selected_time_slot.label') }}
                                        </option>
                                    @else
                                        <option value="">Select a time slot</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Pickup Location Section -->
                        <div id="pickup-location" class="row mt-4" style="display: none;">
                            <div class="col-12">
                                <h3 class="section-title mb-3">Pickup Location</h3>
                                <div class="pickup-address mb-3">
                                    {{-- <p class="mb-2"><strong>Address:</strong></p> --}}
                                    <p class="mb-0">House no. 237, MPCHS, Main road 6, Block B Multi Gardens B-17, Islamabad</p>
                                </div>
                                <div class="map-container" style="position: relative; padding-bottom: 75%; height: 0; overflow: hidden; border-radius: 8px;">
                                    <iframe
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                        loading="lazy"
                                        allowfullscreen
                                        src="https://maps.google.com/maps?q=Bakedspot&output=embed">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div id="delivery-address" class="checkout-section mb-4">
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
                                    @if($orderType == 'pickup')
                                        Cash on Pickup
                                    @else
                                        Cash on Delivery
                                    @endif
                                </label>
                                <div class="payment-description">
                                    <small class="text-muted">
                                        @if($orderType == 'pickup')
                                            Pay with cash when you pick up your order.
                                        @else
                                            Pay with cash when your order is delivered.
                                        @endif
                                    </small>
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
                            $orderType = Session::get('order_type', 'delivery');
                            $selectedSector = session('selected_sector');
                            $selectedTimeSlot = session('selected_time_slot');

                            // Calculate delivery charges based on order type
                            $deliveryCharges = ($orderType == 'delivery' && $selectedSector) ? $selectedSector['delivery_charges'] : 0;
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

                                @if($orderType == 'delivery')
                                <div class="d-flex justify-content-between mb-2" id="delivery-cost-row">
                                    @if($selectedSector)
                                    <span>Delivery to {{ $selectedSector['name'] }}:</span>
                                    <span>PKR {{ number_format($deliveryCharges, 2) }}</span>
                                    @else
                                    <span>Delivery:</span>
                                    <span>PKR 0.00</span>
                                    @endif
                                </div>
                                @elseif($orderType == 'pickup' && $selectedTimeSlot)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Pickup:</span>
                                    <span>{{ $selectedTimeSlot['date'] }} at {{ $selectedTimeSlot['label'] }}</span>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between fw-bold fs-5 mt-3 pt-3 border-top">
                                    <span>Total:</span>
                                    <span id="total-price">PKR {{ number_format($total, 2) }}</span>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryAddressSection = document.getElementById('delivery-address');
        const pickupOptionsSection = document.getElementById('pickup-options');
        const pickupLocationSection = document.getElementById('pickup-location');
        const deliveryCostRow = document.getElementById('delivery-cost-row');
        const totalPriceElement = document.getElementById('total-price');
        const pickupDateInput = document.getElementById('pickup_date');
        const timeSlotSelect = document.getElementById('time_slot');
        const addressInput = document.getElementById('address');
        const cityInput = document.getElementById('city');
        const areaInput = document.getElementById('area');
        const checkoutForm = document.getElementById('checkout-form');

        // Initial subtotal
        const subtotal = {{ $subtotal }};

        @php
            $orderType = Session::get('order_type', 'delivery');
        @endphp

        // Set initial state based on order_type
        if ('{{ $orderType }}' === 'pickup') {
            deliveryAddressSection.style.display = 'none';
            pickupOptionsSection.style.display = 'block';
            pickupLocationSection.style.display = 'block';
            if (deliveryCostRow) {
                deliveryCostRow.style.display = 'none';
            }

            // Make address fields not required for pickup
            addressInput.required = false;
            cityInput.required = false;
            areaInput.required = false;

            // Set placeholder values for address fields for pickup
            if (!addressInput.value) addressInput.value = 'Pickup';
            if (!cityInput.value) cityInput.value = 'Pickup';
            if (!areaInput.value) areaInput.value = 'Pickup';

            // Update total without delivery charges
            totalPriceElement.textContent = 'PKR ' + subtotal.toFixed(2);
        } else {
            deliveryAddressSection.style.display = 'block';
            pickupOptionsSection.style.display = 'none';
            pickupLocationSection.style.display = 'none';
            if (deliveryCostRow) {
                deliveryCostRow.style.display = 'flex';
            }

            // Make address fields required
            addressInput.required = true;
            cityInput.required = true;
            areaInput.required = true;

            // Update total with delivery charges
            const deliveryCharges = {{ $selectedSector ? $selectedSector['delivery_charges'] : 0 }};
            const total = subtotal + deliveryCharges;
            totalPriceElement.textContent = 'PKR ' + total.toFixed(2);
        }

        // Handle form submission
        checkoutForm.addEventListener('submit', function(e) {
            if ('{{ $orderType }}' === 'pickup') {
                // Validate that we have a time slot selected for pickup
                if (timeSlotSelect.value === '') {
                    e.preventDefault();
                    alert('Please select a time slot for pickup');
                    return false;
                }
            }
        });

        // Handle date change for time slots
        pickupDateInput.addEventListener('change', function() {
            const selectedDate = this.value;

            // Clear current options except the preselected one if it exists
            const selectedOption = timeSlotSelect.value;
            const selectedText = timeSlotSelect.options[timeSlotSelect.selectedIndex]?.text;

            timeSlotSelect.innerHTML = '<option value="">Select a time slot</option>';

            // Add back the selected option if we're on the same date as the pre-selected one
            if (selectedOption && selectedDate === '{{ Session::get('selected_time_slot.date', '') }}') {
                const option = document.createElement('option');
                option.value = selectedOption;
                option.textContent = selectedText;
                option.selected = true;
                timeSlotSelect.appendChild(option);
                return;
            }

            // Fetch new time slots
            fetch(`{{ route('checkout.time_slots') }}?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.value;
                            option.textContent = slot.label;
                            timeSlotSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No time slots available for this date';
                        timeSlotSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching time slots:', error);
                });
        });
    });
</script>
@endsection
