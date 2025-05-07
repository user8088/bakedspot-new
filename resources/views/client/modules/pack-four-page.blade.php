@extends('client.layouts.main')

@section('page')
<section class="pack4">
    <div class="container pt-0 pt-md-5 pb-0 pb-md-5">
        <div class="row">
            <!-- Pink Container -->
            <div class="col-lg-6 pack-background position-relative">
                <div class="container-box" id="selected-items-container">
                    <!-- Selected images will appear here -->
                </div>
            </div>
            <!-- Selection Panel -->
            <div class="col-lg-6">
                <h1 class="heading-black-small pb-3 pt-3 ps-0 ps-md-5">Select 4 Flavors</h1>
                <div class="row ps-0 ps-md-5">
                    @foreach ($products as $product)
                        <div class="d-flex align-items-center justify-content-between border-bottom my-2">
                            <div class="d-flex align-items-center">
                                @if ($product->images->isNotEmpty() && $product->images->first()->pack_image_url)
                                <img src="{{asset($product->images->first()->pack_image_url) }}" class="flavor-img me-3" width="50">
                                @else
                                    <img src="{{ asset('images/default-image.png') }}" class="flavor-img me-3" width="50">
                                @endif
                                <div>
                                    <strong>{{ $product->name }}</strong><br>
                                    <span>PKR. {{ $product->price }}</span>
                                </div>
                            </div>
                            <div class="counter d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-dark decrease" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->images->isNotEmpty() && $product->images->first()->pack_image_url ? asset($product->images->first()->pack_image_url)  : asset('images/default-image.png') }}" data-id="{{ $product->id }}">-</button>
                                <span class="mx-2 quantity" data-name="{{ $product->name }}">0</span>
                                <button class="btn btn-sm btn-outline-dark increase" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->images->isNotEmpty() && $product->images->first()->pack_image_url ? asset($product->images->first()->pack_image_url) : asset('images/default-image.png') }}" data-id="{{ $product->id }}">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-end text-md-end text-center sticky-bottom pb-3">
                    <form id="cart-form" method="POST" action="{{ route('cart.add') }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="pack_type" value="Pack of 4">
                        <input type="hidden" name="item_1">
                        <input type="hidden" name="item_2">
                        <input type="hidden" name="item_3">
                        <input type="hidden" name="item_4">
                        <input type="hidden" name="item_5">
                        <input type="hidden" name="item_6">
                        <input type="hidden" name="item_7">
                        <input type="hidden" name="item_8">
                        <input type="hidden" name="total_price">
                    </form>
                    <button class="btn btn-order mt-3 p-3" id="add-to-bag" style="opacity: 0.5; pointer-events: none;">Add 4 More - PKR 0.00</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('selected-items-container');
        const addToBagButton = document.getElementById('add-to-bag');
        let totalPrice = 0;
        let totalSelected = 0;
        let selectedItems = {};

        // Function to update the selected images
        function updateSelectedImages(id, name, imageSrc, isAdding) {
            if (isAdding) {
                // Add new image
                let img = document.createElement('img');
                img.src = imageSrc;
                img.classList.add('selected-img');
                img.setAttribute('data-name', name);
                container.appendChild(img);
            } else {
                // Remove last image of this type
                const images = document.querySelectorAll(`.selected-img[data-name="${name}"]`);
                if (images.length > 0) {
                    images[images.length - 1].remove();
                }
            }
        }

        // Function to update the button state
        function updateButton() {
            let remaining = 4 - totalSelected;

            if (remaining === 0) {
                addToBagButton.innerText = `Add to Bag - PKR ${totalPrice.toFixed(2)}`;
                addToBagButton.style.opacity = '1';
                addToBagButton.style.pointerEvents = 'auto';
            } else {
                addToBagButton.innerText = `Add ${remaining} More - PKR ${totalPrice.toFixed(2)}`;
                addToBagButton.style.opacity = '0.5';
                addToBagButton.style.pointerEvents = 'none';
            }
        }

        // Increase quantity
        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                const imageSrc = this.getAttribute('data-image');
                const quantitySpan = document.querySelector(`.quantity[data-name="${name}"]`);
                let quantity = parseInt(quantitySpan.innerText);

                if (quantity < 4 && totalSelected < 4) {
                    quantity++;
                    quantitySpan.innerText = quantity;
                    totalSelected++;
                    totalPrice += price;

                    if (!selectedItems[id]) {
                        selectedItems[id] = {
                            name: name,
                            price: price,
                            quantity: 0,
                            image: imageSrc
                        };
                    }
                    selectedItems[id].quantity++;

                    updateSelectedImages(id, name, imageSrc, true);
                    updateButton();
                }
            });
        });

        // Decrease quantity
        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                const quantitySpan = document.querySelector(`.quantity[data-name="${name}"]`);
                let quantity = parseInt(quantitySpan.innerText);

                if (quantity > 0) {
                    quantity--;
                    quantitySpan.innerText = quantity;
                    totalSelected--;
                    totalPrice -= price;

                    if (selectedItems[id]) {
                        selectedItems[id].quantity--;
                        if (selectedItems[id].quantity === 0) {
                            delete selectedItems[id];
                        }
                    }

                    updateSelectedImages(id, name, null, false);
                    updateButton();
                }
            });
        });

        addToBagButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (totalSelected !== 4) return; // Safety check

            const form = document.getElementById('cart-form');

            // Fill in the selected item IDs
            let selectedIds = [];
            for (let id in selectedItems) {
                for (let i = 0; i < selectedItems[id].quantity; i++) {
                    selectedIds.push(id);
                }
            }

            // Fill form inputs
            for (let i = 1; i <= 8; i++) {
                const input = form.querySelector(`[name="item_${i}"]`);
                input.value = selectedIds[i - 1] ?? ''; // Empty string if not selected
            }

            form.querySelector('[name="total_price"]').value = totalPrice.toFixed(2);

            // Create FormData and log it
            const formData = new FormData(form);
            console.log('Form data before submission:', Object.fromEntries(formData));

            // Show loading state
            addToBagButton.disabled = true;
            addToBagButton.innerHTML = '<span class="spinner-border spinner-border-sm" style="color: #ffc0cb;" role="status" aria-hidden="true"></span> Adding...';

            // Submit form via AJAX
            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Animate cart button
                        animateCartButton();

                        // Call the navbar's updateCartCount function with response.cartCount
                        if (typeof window.updateCartCount === 'function') {
                            window.updateCartCount(response.cartCount);
                        }

                        // First fetch the updated cart contents and then show the offcanvas
                        $.ajax({
                            url: '{{ route("cart.show") }}',
                            type: 'GET',
                            success: function(cartResponse) {
                                // Build cart HTML manually since the offcanvas is already in the DOM
                                buildCartHTML(cartResponse);

                                // Show the offcanvas after content is updated
                                const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
                                cartOffcanvas.show();

                                // Show success message
                                showToast('Item added to cart successfully');
                            },
                            error: function() {
                                // Still show the cart even if refresh fails
                                const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
                                cartOffcanvas.show();
                                showToast('Item added to cart successfully');
                            }
                        });

                        // Reset form
                        form.reset();

                        // Reset button state
                        addToBagButton.disabled = false;
                        addToBagButton.textContent = 'Add to Bag';
                    } else {
                        showToast(response.message || 'Failed to add item to cart', 'error');
                        addToBagButton.disabled = false;
                        addToBagButton.textContent = 'Add to Bag';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error response:', xhr.responseJSON);
                    let errorMessage = 'Failed to add item to cart. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showToast(errorMessage, 'error');
                    addToBagButton.disabled = false;
                    addToBagButton.textContent = 'Add to Bag';
                }
            });
        });
    });

    function refreshCart() {
        $.ajax({
            url: '{{ route("cart.show") }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Call the navbar's updateCartCount function
                if (typeof window.updateCartCount === 'function') {
                    window.updateCartCount(response.cartItems ? response.cartItems.length : 0);
                }

                // Build the cart HTML
                buildCartHTML(response);

                console.log('Cart refreshed successfully');
            },
            error: function(xhr, status, error) {
                console.error('Failed to refresh cart:', error);
                showToast('Failed to refresh cart', 'error');
            }
        });
    }

    function buildCartHTML(response) {
        // Get the cart items container
        const cartItemsContainer = document.getElementById('cartItems');
        if (!cartItemsContainer) return;

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

            // Check order type
            const orderType = response.order_type || 'delivery';

            // Add delivery info if sector is selected (for delivery orders)
            if (orderType === 'delivery') {
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
            }
            // Add pickup info if time slot is selected (for pickup orders)
            else if (orderType === 'pickup') {
                if (response.selected_time_slot) {
                    html += `
                    <div class="d-flex justify-content-between mt-2">
                        <span>Pickup:</span>
                        <span class="text-success"><b>${response.selected_time_slot.date} at ${response.selected_time_slot.label}</b></span>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold">PKR ${subtotal.toFixed(2)}</span>
                    </div>`;
                } else {
                    html += `
                    <div class="alert alert-warning mt-3 py-2 small">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Please <a href="{{ route('pickup-packmenupage') }}" class="alert-link">select a pickup time</a> to continue.
                    </div>`;
                }
            }

            html += `
                </div>
            </div>`;
        }

        // Update cart items container
        cartItemsContainer.innerHTML = html;

        // Update checkout button
        const checkoutBtnContainer = document.querySelector('.offcanvas-body > .mt-4');
        if (checkoutBtnContainer) {
            let checkoutBtn = '';
            if (response.cartItems && response.cartItems.length > 0) {
                const orderType = response.order_type || 'delivery';

                if ((orderType === 'delivery' && response.selected_sector) ||
                    (orderType === 'pickup' && response.selected_time_slot)) {
                    checkoutBtn = '<a href="{{ route("checkout.show") }}" class="btn btn-main w-100">Proceed to Checkout</a>';
                } else if (orderType === 'delivery') {
                    checkoutBtn = '<a href="{{ route("get-packmenupage") }}" class="btn btn-main w-100">Select Delivery Area</a>';
                } else {
                    checkoutBtn = '<a href="{{ route("pickup-packmenupage") }}" class="btn btn-main w-100">Select Pickup Time</a>';
                }
            } else {
                checkoutBtn = '<a href="{{ route("get-packmenupage") }}" class="btn btn-main w-100">Order Now</a>';
            }
            checkoutBtnContainer.innerHTML = checkoutBtn;
        }
    }

    function animateCartButton() {
        const cartBtn = document.getElementById('cartBtn');
        if (cartBtn) {
            cartBtn.classList.add('pulse-animation');
            setTimeout(() => {
                cartBtn.classList.remove('pulse-animation');
            }, 1000);
        }
    }
</script>

@endsection
