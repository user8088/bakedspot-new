@extends('client.layouts.home-layout')
@section('page')
    {{-- Full-Screen Video Section --}}
    <section class="video-section">
        <div class="navbar-container">
            @include('client.partials.navbar')
        </div>
        <video autoplay muted loop playsinline class="hero-video">
            <source src="https://cdn.pixabay.com/video/2021/11/18/98283-647561752_large.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay-content">
            <h1 class="heroheading" style="color: white;">Best brownies in town.</h1>
            <div class="overlay-content-button d-flex justify-content-center position-absolute bottom-0 w-100 pb-4">
                <a href="{{route('start-order')}}" class="btn btn-main py-3 px-3">
                    <span class="fw-bold button-text">Order Now</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Desktop Product Section --}}
    <section class="content-section position-relative d-none d-md-block">
        <div class="container">
            <h1 class="secondaryheading pt-5 pb-5">Our Yummers</h1>
            @foreach ($products as $product)
        @if($loop->index % 2 == 0)
            <!-- Layout for even-indexed products -->
            <div class="container home-brownie-container position-relative my-5 py-5" data-bg-color="{{ $product->theme_color }}">
                    <div class="row pt-5 pb-5 align-items-center justify-content-center text-center text-lg-start position-relative">
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
            <div class="container home-brownie-container position-relative my-5 py-5" data-bg-color="{{ $product->theme_color }}">
                <div class="row pt-5 pb-5 align-items-center justify-content-center text-center text-lg-start position-relative">
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
        <div class="container-fluid px-0">
            <h1 class="flavor-heading px-3">Our Yummers</h1>
            @foreach ($products as $product)
                <div class="mobile-product-item {{ $loop->index % 2 == 0 ? 'image-left' : 'image-right' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="product-image-wrapper">
                            @if($product->images->first()?->home_image_url)
                                <img src="{{ asset($product->images->first()->home_image_url) }}" class="product-image" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="product-info ">
                            <h2 class="product-name {{ $loop->index % 2 == 0 ? 'text-start' : 'text-end' }}">{{ $product->name }}</h2>
                            <a href="{{ route('get-productdetailspage', $product->id) }}" class="learn-more">
                                Learn More <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
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

<style>
    .fixed-order-btn-container {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 100%;
        text-align: center;
    }

    .fixed-order-btn-container .btn-main {
        background-color: #000;
        color: white;
        border-radius: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .fixed-order-btn-container .btn-main:hover {
        background-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .fixed-order-btn-container .btn-main {
            padding: 12px 30px;
        }
    }

    .overlay-content {
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .overlay-content-button {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding-bottom: 1.5rem;
    }

    .overlay-content-button .btn-main {
        background-color: #000;
        color: white;
        border-radius: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .overlay-content-button .btn-main:hover {
        background-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .home-brownie-container {
        margin: 4rem 0;
        padding: 3rem 0;
        transition: all 0.3s ease;
    }

    .cookie-image {
        max-height: 400px;
        object-fit: contain;
        margin: 2rem 0;
    }

    .product-heading {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }

    @media (min-width: 992px) {
        .home-brownie-container {
            margin: 5rem 0;
            padding: 4rem 0;
        }
    }

    /* Ensure proper stacking context */
    .row {
        position: relative;
        z-index: 2;
    }

    /* Add extra margin to prevent overlap */
    .content-section .container {
        margin-bottom: 8rem;
    }
</style>
