<nav class="navbar mainnavbar navbar-expand-lg p-3 sticky-top">
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
                            <span class="fw-bold button-text">Order Now</span>
                        </a>
                    @else
                        <button id="cartBtn" class="btn btn-main py-2 px-3" data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                            <i class="fas fa-shopping-bag me-2"></i>
                            <span class="fw-bold button-text">View Bag ({{ $cartCount }})</span>
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
    function updateCartCount(count) {
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
                    <i class="fas fa-shopping-bag me-2"></i>
                    <span class="fw-bold button-text">View Bag (${count})</span>
                `;
                cartButtons.appendChild(newCartBtn);
            } else {
                // Update existing cart button count
                cartBtn.querySelector('.button-text').textContent = `View Bag (${count})`;
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
                newOrderBtn.innerHTML = '<span class="fw-bold button-text">Order Now</span>';
                cartButtons.appendChild(newOrderBtn);
            }
        }
    }
</script>
