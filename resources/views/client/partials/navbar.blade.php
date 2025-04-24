<nav class="navbar mainnavbar navbar-expand-lg p-3 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Offcanvas Toggler (Left Menu) -->
        <button class="sidebar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <div class="d-flex align-items-center">
                <i class="fas fa-bars me-2"></i>
            </div>
        </button>

        <!-- Logo in the Center -->
        <a class="navbar-brand mx-lg-0 mx-auto" href="/">
            <img src="{{ asset('images/logo.png') }}" width="180" alt="">
        </a>

        <!-- Order Now / Bag Button -->
        <div id="cart-buttons" class="d-flex align-items-center">
            <!-- Initially visible -->
            <a id="orderNowBtn" href="{{route('get-packmenupage')}}" class="btn btn-order py-2 px-3 d-none">
                <span class="fw-bold button-text">Order Now</span>
            </a>

            <!-- Hidden until cart has item -->
            <button id="cartBtn" class="btn btn-main py-2 px-3" data-bs-toggle="offcanvas"
                data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                <i class="fas fa-shopping-bag me-2"></i>
                <span class="fw-bold button-text">View Bag</span>
            </button>
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
    function showCartButton() {
        const orderNowBtn = document.getElementById('orderNowBtn');
        const cartBtn = document.getElementById('cartBtn');

        orderNowBtn.classList.add('d-none');
        cartBtn.classList.remove('d-none');
    }

    // Example usage:
    // Call `showCartButton()` when user adds item to cart
    // You can hook this into your "Add to Cart" button logic
</script>
