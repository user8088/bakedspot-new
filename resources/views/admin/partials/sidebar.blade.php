<!-- SIDE BAR DESKTOP -->
<div class="col-md-2 sidebar sticky-top shadow mt-3 d-none d-lg-block" id="sidebar-desktop">
    <div class="mb-4">
        <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo" width="200" height="100" />
    </div>
    <nav class="nav flex-column">
        <a class="nav-link p-2" href="{{route('get-admindashboard')}}"><img src="{{ asset('icons/dashboard-icon.png') }}" class="img-fluid" alt="Dashboard" width="20" height="20" /><span class="ps-3 dashboard-text">Dashboard</span></a>
        <a class="nav-link p-2" href="{{route('get-productmanagmentpage')}}"><img src="{{ asset('icons/user-managment-icon.png') }}" class="img-fluid" alt="User Management" width="20" height="20" /><span class="ps-3 dashboard-text">Product Managment</span></a>
        <a class="nav-link p-2" href="#"><img src="{{ asset('icons/stock-managment-icon.png') }}" class="img-fluid" alt="Stock Management" width="20" height="20" /><span class="ps-3 dashboard-text">Order Management</span></a>
        <a class="nav-link p-2" href="#"><img src="{{ asset('icons/vendor-managment-icon.png') }}" class="img-fluid" alt="Vendor Management" width="20" height="20" /><span class="ps-3 dashboard-text">Sector Management</span></a>

        <div>
            <ul class="navbar-nav text-center  pt-5">
                <li class="nav-item pe-3">
                    <form action="{{route('logout-admin')}}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-main px-5 py-3">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- SIDE BAR CODE ENDS HERE -->

<!-- BOTTOM MOBILE NAVBAR -->
<div class="d-block d-lg-none fixed-bottom bg-white shadow-lg py-2" id="mobile-navbar">
    <div class="container d-flex justify-content-around">
        <a href="#" class="nav-link text-center">
            <img src="{{ asset('images/dashboard-icon.png') }}" width="24" height="24" alt="Dashboard">
            <p class="small m-0">Dashboard</p>
        </a>
        <a href="#" class="nav-link text-center">
            <img src="{{ asset('images/user-managment-icon.png') }}" width="24" height="24" alt="Users">
            <p class="small m-0">Users</p>
        </a>
        <a href="#" class="nav-link text-center">
            <img src="{{ asset('images/stock-managment-icon.png') }}" width="24" height="24" alt="Stock">
            <p class="small m-0">Stock</p>
        </a>
        <a href="#" class="nav-link text-center">
            <img src="{{ asset('images/vendor-managment-icon.png') }}" width="24" height="24" alt="Vendors">
            <p class="small m-0">Vendors</p>
        </a>
        <a href="#" class="nav-link text-center">
            <img src="{{ asset('images/admin-user-icon.png') }}" width="24" height="24" alt="Admin">
            <p class="small m-0">Admins</p>
        </a>
    </div>
</div>
<!-- BOTTOM MOBILE NAVBAR ENDS -->
