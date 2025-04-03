@include('admin.partials.header')
<body>
    <div class="dashboard-wrapper">
        <div class="dashboard-content">
            @include('admin.partials.navbar')
            <div class="container-fluid px-0 px-md-5 px-lg-5">
                <div class="row">
                    @include("admin.partials.sidebar")
                    @yield('page')
                </div>
            </div>
        </div>
    </div>
</body>
@include('admin.partials.footer')
