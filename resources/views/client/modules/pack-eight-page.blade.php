@extends('client.layouts.main')

@section('page')
<section class="pack8">
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
                <h1 class="heading-black-small pb-3 pt-3 ps-0 ps-md-5">Select 8 Flavors</h1>
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
                        <input type="hidden" name="pack_type" value="Pack of 8">
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
                    <button class="btn btn-order mt-3 p-3" id="add-to-bag" style="opacity: 0.5; pointer-events: none;">Add 8 More - PKR 0.00</button>
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
        const form = document.getElementById('cart-form');
        let totalPrice = 0;
        let totalSelected = 0;
        let selectedItems = {};

        function updateSelectedImages(id, name, imageSrc, isAdding) {
            if (isAdding) {
                let img = document.createElement('img');
                img.src = imageSrc;
                img.classList.add('selected-img');
                img.setAttribute('data-name', name);
                container.appendChild(img);
            } else {
                const images = document.querySelectorAll(`.selected-img[data-name="${name}"]`);
                if (images.length > 0) {
                    images[images.length - 1].remove();
                }
            }
        }

        function updateButton() {
            let remaining = 8 - totalSelected;
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

        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                const imageSrc = this.getAttribute('data-image');
                const quantitySpan = document.querySelector(`.quantity[data-name="${name}"]`);
                let quantity = parseInt(quantitySpan.innerText);

                if (quantity < 8 && totalSelected < 8) {
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

        function showToast(message, type = 'success') {
            const toast = $(`
                <div class="custom-toast ${type}">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `);

            $('.toast-container').append(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.css('animation', 'slideOut 0.3s ease-out');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        addToBagButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (totalSelected !== 8) return;

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
                    console.log('Success response:', response);
                    if (response.success) {
                        // Animate cart button
                        animateCartButton();

                        // Update cart count and button visibility
                        updateCartCount(response.cartCount);

                        // Refresh cart contents
                        refreshCart();

                        // Show the cart offcanvas
                        const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
                        cartOffcanvas.show();

                        // Show success message
                        showToast('Item added to cart successfully');

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
</script>

@endsection
