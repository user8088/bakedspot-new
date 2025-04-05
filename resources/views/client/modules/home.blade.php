@extends('client.layouts.main')
@section('page')
    {{-- Full-Screen Video Section --}}
<section class="video-section">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="https://cdn.pixabay.com/video/2021/11/18/98283-647561752_large.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="overlay-content">
        <h1 class="heroheading" style="color: white;">Best brownies in town.</h1>
        <a href="{{route('start-order')}}" class="btn btn-main py-3 px-3">
            <span class="fw-bold button-text">Order Now</span>
        </a>
    </div>
</section>

{{-- Desktop Product Section --}}
<section class="content-section position-relative d-none d-md-block">
    <div class="container">
        <h1 class="secondaryheading pt-5 pb-5">Our Yummers</h1>
        @foreach ($products as $product)
    @if($loop->index % 2 == 0)
        <!-- Layout for even-indexed products -->
        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5" data-bg-color="{{ $product->theme_color }}">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        @if($product->images->first()?->home_image_url)
                            <img src="{{ asset($product->images->first()->home_image_url) }}" class="img-fluid cookie-image" alt="Product Image">
                        @endif
                    </div>
                    <div class="col-lg-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">{{$product->name}}</h1>
                        <p>{{$product->description}}</p>
                        <div>
                            <a href="{{ route('get-productdetailspage', $product->id) }}" class="btn btn-outline-light me-2">Learn More</a>
                            <a href="{{route('start-order')}}" class="btn btn-light">Order Now</a>
                        </div>
                    </div>
            </div>
        </div>
    @else
        <!-- Layout for odd-indexed products (switches order of image and text) -->
        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5" data-bg-color="{{ $product->theme_color }}">
            <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                <div class="col-lg-6 ps-0 ps-md-5 ps-lg-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white order-2 order-md-1">
                    <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">{{$product->name}}</h1>
                    <p>{{$product->description}}</p>
                    <div>
                        <a href="{{ route('get-productdetailspage', $product->id) }}" class="btn btn-outline-light me-2">Learn More</a>
                        <a href="{{route('start-order')}}" class="btn btn-light">Order Now</a>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center position-relative order-1 order-md-2">
                    @if($product->images->first()?->home_image_url)
                        <img src="{{ asset($product->images->first()->home_image_url) }}" class="img-fluid cookie-image" alt="Product Image">
                    @endif
                </div>
            </div>
        </div>
    @endif
@endforeach
    </div>
</section>

{{-- Mobile Product Section --}}
<section class="content-section-mobile d-block d-md-none">
    <div class="container pb-4">
        <h1 class="secondaryheading-mobile pt-3">Our Yummers</h1>
        @foreach ($products as $product)
            @if($loop->index % 2 == 0)
                <!-- Layout for even-indexed products -->
                <div class="row g-2 pt-4">
                    <div class="col-6">
                        @if($product->images->first()?->home_image_url)
                            <img src="{{ asset($product->images->first()->home_image_url) }}" class="img-fluid" alt="Product Image">
                        @endif
                    </div>
                    <div class="col-6">
                        <h1 class="mobile-product-heading pt-3">{{ $product->name }}</h1>
                        <a href="{{ route('get-productdetailspage', $product->id) }}" class="btn btn-outline-light me-2" style="color: #000">Learn More</a>
                    </div>
                </div>
            @else
                <!-- Layout for odd-indexed products (switches order of image and text) -->
                <div class="row g-2 pt-4">
                    <div class="col-6">
                        <h1 class="mobile-product-heading pt-3">{{ $product->name }}</h1>
                        <a href="{{ route('get-productdetailspage', $product->id) }}" class="btn btn-outline-light me-2" style="color: #000">Learn More</a>
                    </div>
                    <div class="col-6">
                        @if($product->images->first()?->home_image_url)
                            <img src="{{ asset($product->images->first()->home_image_url) }}" class="img-fluid" alt="Product Image">
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all product containers
        const containers = document.querySelectorAll('.home-brownie-container');

        containers.forEach(container => {
            // Get the background color from the data attribute
            const bgColor = container.getAttribute('data-bg-color');

            // Set the initial background color (optional)
            container.style.backgroundColor = '#fff'; // Or any default color

            // Add hover effect using JavaScript
            container.addEventListener('mouseenter', function() {
                container.style.backgroundColor = bgColor;  // Set the dynamic hover color
            });

            container.addEventListener('mouseleave', function() {
                container.style.backgroundColor = '#fff';  // Reset to default color
            });
        });
    });
</script>


@include('client.partials.footer')

@endsection
