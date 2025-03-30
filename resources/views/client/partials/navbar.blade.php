<nav class="navbar navbar-expand-lg p-3 sticky-top" >
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Offcanvas Toggler -->
        <button class="sidebar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <div class="d-flex align-items-center">
                <i class="fas fa-bars me-2"></i>
            </div>
        </button>

        <!-- Logo in the Center -->
        <a class="navbar-brand mx-auto" href="#"><img src="{{asset('images/logo.png')}}" width="180" alt=""></a>

        <!-- Order Now Button on the Right -->
        <a href="#" class="btn btn-order py-3 px-3">
            <span class="fw-bold button-text">Order Now</span>
        </a>
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
