<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartOffcanvasLabel">Your Bag</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="cartItems">
            @php
                $sessionId = Session::getId();
                $cartItems = \App\Models\Cart::where('session_id', $sessionId)->get();
                $selectedSector = session('selected_sector');

                \Illuminate\Support\Facades\Log::info('Cart View - Session ID: ' . $sessionId);
                \Illuminate\Support\Facades\Log::info('Cart View - Found ' . $cartItems->count() . ' items');
            @endphp

            @if($cartItems->isEmpty())
                <p class="text-center">Your bag is empty.</p>
            @else
                @php
                    $subtotal = 0;
                @endphp
                @foreach($cartItems as $item)
                    @php
                        $subtotal += floatval($item->total_price);
                    @endphp
                    <div class="row cart-item pb-3 pt-3 border-top" data-cart-id="{{ $item->id }}">
                        <div class="col-lg-3">
                            <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-3">
                            <p class="pt-2">{{ $item->pack_type }}</p>
                        </div>
                        <div class="col-lg-4">
                            <p class="pt-2"><b>PKR {{ number_format($item->total_price, 2) }}</b></p>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-link p-0 remove-item" data-cart-id="{{ $item->id }}">
                                <i class="fas fa-trash-alt text-danger" title="Remove item"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <h6 class="text-muted">Order Summary</h6>

                        <div class="d-flex justify-content-between mt-3">
                            <span>Subtotal:</span>
                            <span><b>PKR {{ number_format($subtotal, 2) }}</b></span>
                        </div>

                        @php
                            $orderType = Session::get('order_type', 'delivery');
                            $selectedSector = Session::get('selected_sector');
                            $selectedTimeSlot = Session::get('selected_time_slot');
                            $total = $subtotal;
                        @endphp

                        @if($orderType == 'delivery' && $selectedSector)
                            <div class="d-flex justify-content-between mt-2">
                                <span>Delivery to {{ $selectedSector['name'] }}:</span>
                                <span><b>PKR {{ number_format($selectedSector['delivery_charges'], 2) }}</b></span>
                            </div>
                            @php
                                $total += floatval($selectedSector['delivery_charges']);
                            @endphp
                        @elseif($orderType == 'pickup' && $selectedTimeSlot)
                            <div class="d-flex justify-content-between mt-2">
                                <span>Pickup:</span>
                                <span class="text-success"><b>{{ $selectedTimeSlot['date'] }} at {{ $selectedTimeSlot['label'] }}</b></span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-3">
                            <span class="fw-bold">Total:</span>
                            <span class="fw-bold">PKR {{ number_format($total, 2) }}</span>
                        </div>

                        @if($orderType == 'delivery' && !$selectedSector)
                            <div class="alert alert-warning mt-3 py-2 small">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Please <a href="{{ route('get-packmenupage') }}" class="alert-link">select a delivery area</a> to continue.
                            </div>
                        @elseif($orderType == 'pickup' && !$selectedTimeSlot)
                            <div class="alert alert-warning mt-3 py-2 small">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Please <a href="{{ route('pickup-packmenupage') }}" class="alert-link">select a pickup time</a> to continue.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="mt-4">
            @if(isset($cartItems) && count($cartItems) > 0)
                @php
                    $orderType = Session::get('order_type', 'delivery');
                    $selectedSector = Session::get('selected_sector');
                    $selectedTimeSlot = Session::get('selected_time_slot');
                @endphp

                @if(($orderType == 'delivery' && $selectedSector) || ($orderType == 'pickup' && $selectedTimeSlot))
                    <a href="{{ route('checkout.show') }}" class="btn btn-main w-100">Proceed to Checkout</a>
                @elseif($orderType == 'delivery')
                    <a href="{{ route('get-packmenupage') }}" class="btn btn-main w-100">Select Delivery Area</a>
                @else
                    <a href="{{ route('pickup-packmenupage') }}" class="btn btn-main w-100">Select Pickup Time</a>
                @endif
            @else
                <a href="{{ route('start-order') }}" class="btn btn-main w-100">Order Now</a>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle remove item click
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();
            const cartId = $(this).data('cart-id');
            const cartItem = $(this).closest('.cart-item');

            // Show loading state with pink spinner
            cartItem.html('<div class="col-12 text-center"><div class="spinner-border" style="color: #ffc0cb;" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            $.ajax({
                url: '{{ route("cart.remove") }}',
                type: 'POST',
                data: {
                    cart_id: cartId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the item from the DOM
                        cartItem.fadeOut(300, function() {
                            $(this).remove();
                            // If no items left, show empty message
                            if ($('.cart-item').length === 0) {
                                $('#cartItems').html('<p class="text-center">Your bag is empty.</p>');
                            }
                            // Update cart count
                            if (typeof window.updateCartCount === 'function') {
                                window.updateCartCount($('.cart-item').length);
                            }
                            // Show success message
                            showToast('Item removed from cart');
                            // Refresh entire cart to update totals without showing additional toasts
                            refreshCartSilent();
                        });
                    } else {
                        // Show error message
                        cartItem.html('<div class="col-12 text-center text-danger">Failed to remove item. Please try again.</div>');
                        showToast('Failed to remove item', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to remove item:', error);
                    cartItem.html('<div class="col-12 text-center text-danger">Failed to remove item. Please try again.</div>');
                    showToast('Failed to remove item', 'error');
                }
            });
        });
    });

    function refreshCart() {
        // Show loading state with pink spinner
        $('#cartItems').html('<div class="text-center"><div class="spinner-border" style="color: #ffc0cb;" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '{{ route("cart.show") }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                updateCartHTML(response);
            },
            error: function(xhr, status, error) {
                console.error('Failed to refresh cart:', error);
                $('#cartItems').html('<p class="text-center text-danger">Failed to load cart items. Please try again.</p>');
                showToast('Failed to load cart items', 'error');
            }
        });
    }

    // Silent version that doesn't show error toasts
    function refreshCartSilent() {
        // Show loading state with pink spinner
        $('#cartItems').html('<div class="text-center"><div class="spinner-border" style="color: #ffc0cb;" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '{{ route("cart.show") }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                updateCartHTML(response);
            },
            error: function(xhr, status, error) {
                console.error('Failed to refresh cart silently:', error);
                $('#cartItems').html('<p class="text-center text-danger">Failed to load cart items. Please try again.</p>');
                // No toast shown
            }
        });
    }

    // Common function to update cart HTML
    function updateCartHTML(response) {
        // Build the cart HTML based on the JSON response
        let html = '';

        if (!response.cartItems || response.cartItems.length === 0) {
            html = '<p class="text-center">Your bag is empty.</p>';
        } else {
            // Calculate subtotal
            let subtotal = 0;

            // Add cart items
            response.cartItems.forEach(function(item) {
                subtotal += parseFloat(item.total_price);
                html += `
                <div class="row cart-item pb-3 pt-3 border-top" data-cart-id="${item.id}">
                    <div class="col-lg-3">
                        <img src="{{ asset('images/pk-4.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-3">
                        <p class="pt-2">${item.pack_type}</p>
                    </div>
                    <div class="col-lg-4">
                        <p class="pt-2"><b>PKR ${parseFloat(item.total_price).toFixed(2)}</b></p>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-link p-0 remove-item" data-cart-id="${item.id}">
                            <i class="fas fa-trash-alt text-danger" title="Remove item"></i>
                        </button>
                    </div>
                </div>`;
            });

            // Add order summary
            html += `
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <h6 class="text-muted">Order Summary</h6>

                    <div class="d-flex justify-content-between mt-3">
                        <span>Subtotal:</span>
                        <span><b>PKR ${subtotal.toFixed(2)}</b></span>
                    </div>`;

            // Add delivery info if sector is selected
            if (response.selected_sector) {
                const deliveryCharges = parseFloat(response.selected_sector.delivery_charges);
                const total = subtotal + deliveryCharges;

                html += `
                <div class="d-flex justify-content-between mt-2">
                    <span>Delivery to ${response.selected_sector.name}:</span>
                    <span><b>PKR ${deliveryCharges.toFixed(2)}</b></span>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <span class="fw-bold">Total:</span>
                    <span class="fw-bold">PKR ${total.toFixed(2)}</span>
                </div>`;
            } else {
                html += `
                <div class="alert alert-warning mt-3 py-2 small">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Please <a href="{{ route('get-packmenupage') }}" class="alert-link">select a delivery area</a> to continue.
                </div>`;
            }

            html += `
                </div>
            </div>`;
        }

        // Update cart items container
        $('#cartItems').html(html);

        // Update checkout button
        let checkoutBtn = '';
        if (response.cartItems && response.cartItems.length > 0) {
            if (response.selected_sector) {
                checkoutBtn = '<a href="{{ route("checkout.show") }}" class="btn btn-main w-100">Proceed to Checkout</a>';
            } else {
                checkoutBtn = '<a href="{{ route("get-packmenupage") }}" class="btn btn-main w-100">Select Delivery Area</a>';
            }
        } else {
            checkoutBtn = '<a href="{{ route("get-packmenupage") }}" class="btn btn-main w-100">Order Now</a>';
        }
        $('.offcanvas-body > .mt-4').html(checkoutBtn);

        // Update cart count in navbar
        if (typeof window.updateCartCount === 'function') {
            window.updateCartCount(response.cartItems ? response.cartItems.length : 0);
        }
    }
</script>

<style>
    @media (max-width: 767px) {
        .cart-title {
            display: none !important;
        }
    }
    .remove-item {
        cursor: pointer;
    }
    .remove-item:hover {
        opacity: 0.8;
    }
    .spinner-border {
        width: 1.5rem;
        height: 1.5rem;
    }
</style>
