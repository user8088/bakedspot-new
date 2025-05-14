@php
    $currentRoute = request()->route()->getName();
    $isHomePage = $currentRoute === 'home' || request()->is('/');
    $navbarClass = $isHomePage ? 'mainnavbar' : 'mainnavbar non-home-navbar';
@endphp

<nav class="navbar {{ $navbarClass }} navbar-expand-lg p-3 sticky-top">
    <div class="container">
        <div class="row w-100 align-items-center">
            <!-- Offcanvas Toggler (Left Menu) -->
            <div class="col-4">
                <button class="sidebar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bars me-2"></i>
                    </div>
                </button>
            </div>

            <!-- Logo in the Center -->
            <div class="col-4 text-center">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" width="180" alt="">
                </a>
            </div>

            <!-- Order Now / Bag Button -->
            <div class="col-4 text-end">
                <div id="cart-buttons" class="d-flex align-items-center justify-content-end">
                    @php
                        $sessionId = Session::getId();
                        $cartItems = \App\Models\Cart::where('session_id', $sessionId)->get();
                        $cartCount = $cartItems->count();
                    @endphp

                    @if($cartCount === 0)
                        <a id="orderNowBtn" href="{{route('get-packmenupage')}}" class="btn btn-order-nav py-2 px-3">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="fw-bold button-text d-md-inline d-none">Order Now</span>
                        </a>
                    @else
                        <button id="cartBtn" class="btn btn-main py-2 px-3" data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="badge bg-danger rounded-pill cart-count">{{ $cartCount }}</span>
                            <span class="fw-bold button-text d-md-inline d-none">View Bag ({{ $cartCount }})</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>


<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-start p-3" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header border-0 border-bottom">
        <a class="offcanvas-title" id="offcanvasExampleLabel">Sign in</a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <li class="py-2"><a class="nav-link" href="/">Home</a></li>
            <li class="py-2"><a class="nav-link" href="{{route('get-packmenupage')}}">Order</a></li>
            <li class="py-2"><a class="nav-link" href="#">Brownies</a></li>
            <li class="py-2"><a class="nav-link" href="#">Catering</a></li>
            <li class="py-2"><a class="nav-link" href="#">Packaging</a></li>
            <li class="py-2"><a class="nav-link" href="#">About us</a></li>
        </ul>
    </div>
</div>

@include('client.partials.cart')

<script>
    // Make the updateCartCount function globally available
    window.updateCartCount = function(count) {
        const orderNowBtn = document.getElementById('orderNowBtn');
        const cartBtn = document.getElementById('cartBtn');
        const cartButtons = document.getElementById('cart-buttons');

        if (count > 0) {
            // If cart has items, show cart button
            if (orderNowBtn) orderNowBtn.remove();

            if (!cartBtn) {
                // Create cart button if it doesn't exist
                const newCartBtn = document.createElement('button');
                newCartBtn.id = 'cartBtn';
                newCartBtn.className = 'btn btn-main py-2 px-3';
                newCartBtn.setAttribute('data-bs-toggle', 'offcanvas');
                newCartBtn.setAttribute('data-bs-target', '#cartOffcanvas');
                newCartBtn.setAttribute('aria-controls', 'cartOffcanvas');
                newCartBtn.innerHTML = `
                    <i class="fas fa-shopping-bag"></i>
                    <span class="badge bg-danger rounded-pill cart-count">${count}</span>
                    <span class="fw-bold button-text d-md-inline d-none">View Bag (${count})</span>
                `;
                cartButtons.appendChild(newCartBtn);
            } else {
                // Update existing cart button count
                const countBadge = cartBtn.querySelector('.cart-count');
                if (countBadge) {
                    countBadge.textContent = count;
                }
                const buttonText = cartBtn.querySelector('.button-text');
                if (buttonText) {
                    buttonText.textContent = `View Bag (${count})`;
                }
            }
        } else {
            // If cart is empty, show order now button
            if (cartBtn) cartBtn.remove();

            if (!orderNowBtn) {
                // Create order now button if it doesn't exist
                const newOrderBtn = document.createElement('a');
                newOrderBtn.id = 'orderNowBtn';
                newOrderBtn.href = "{{ route('get-packmenupage') }}";
                newOrderBtn.className = 'btn btn-order-nav py-2 px-3';
                newOrderBtn.innerHTML = `
                    <i class="fas fa-shopping-cart"></i>
                    <span class="fw-bold button-text d-md-inline d-none">Order Now</span>
                `;
                cartButtons.appendChild(newOrderBtn);
            }
        }
    }

    // Check if this is not the home page
    document.addEventListener("DOMContentLoaded", function() {
        const isHomePage = window.location.pathname === '/' || window.location.pathname === '';
        const navbar = document.querySelector('.navbar');

        // If this is not home page, add the background color immediately
        if (!isHomePage) {
            navbar.classList.add('non-home-navbar');
        }
    });
</script>

<style>
    .non-home-navbar {
        background-color: #FFB9CD !important;
    }

    /* Cart button styles */
    .cart-count {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(25%, -25%);
        font-size: 0.6rem;
    }

    #cartBtn, #orderNowBtn {
        position: relative;
    }

    @media (max-width: 767px) {
        #cartBtn, #orderNowBtn {
            padding: 0.5rem 0.75rem !important;
        }

        /* Show only icon on mobile */
        #cartBtn .fa-shopping-bag, #orderNowBtn .fa-shopping-cart {
            display: inline-block;
        }
    }

    @media (min-width: 768px) {
        /* Hide icon on desktop, show only text */
        #cartBtn .fa-shopping-bag, #orderNowBtn .fa-shopping-cart {
            display: none;
        }

        /* Show text without d-none on desktop */
        #cartBtn .button-text, #orderNowBtn .button-text {
            display: inline-block !important;
            margin-left: 0 !important;
        }

        /* Hide badge on desktop since count is in text */
        #cartBtn .cart-count {
            display: none;
        }
    }
</style>
