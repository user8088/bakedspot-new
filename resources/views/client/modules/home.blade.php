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
        <a href="{{route('get-packmenupage')}}" class="btn btn-main py-3 px-3">
            <span class="fw-bold button-text">Order Now</span>
        </a>
    </div>
</section>

{{-- Desktop Product Section --}}
<section class="content-section position-relative d-none d-md-block">
    <div class="container">
        <h1 class="secondaryheading pt-5 pb-5">Our Yummers</h1>
        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5">
            <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                <div class="col-lg-6 d-flex justify-content-center position-relative">
                    <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                    <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">Semi-Sweet Chocolate Chunk</h1>
                    <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                    <div>
                        <a href="{{route('get-productdetailspage')}}" class="btn btn-outline-light me-2">Learn More</a>
                        <a href="{{route('get-packmenupage')}}" class="btn btn-light">Order Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5">
            <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                <div class="col-lg-6 ps-0 ps-md-5 ps-lg-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white order-2 order-md-1">
                    <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">Semi-Sweet Chocolate Chunk</h1>
                    <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                    <div>
                        <a href="{{ route('get-productdetailspage') }}" class="btn btn-outline-light me-2">Learn More</a>
                        <a href="{{route('get-packmenupage')}}"class="btn btn-light">Order Now</a>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center position-relative order-1 order-md-2">
                    <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                </div>
            </div>
        </div>

        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5">
            <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                <div class="col-lg-6 d-flex justify-content-center position-relative">
                    <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                    <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">Semi-Sweet Chocolate Chunk</h1>
                    <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                    <div>
                        <a href="{{route('get-productdetailspage')}}" class="btn btn-outline-light me-2">Learn More</a>
                        <a href="{{route('get-packmenupage')}}" class="btn btn-light">Order Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container home-brownie-container  position-relative mt-5 pt-5 mb-5">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 ps-0 ps-md-5 ps-lg-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white order-2 order-md-1">
                        <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <a href="{{route('get-packmenupage')}}" class="btn btn-light">Order Now</a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center position-relative order-1 order-md-2">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                </div>
            </a>
        </div>
        <div class="container home-brownie-container position-relative mt-5 pt-5 mb-5">
            <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                <div class="col-lg-6 d-flex justify-content-center position-relative">
                    <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                    <h1 class="fw-bold product-heading pt-5 mt-5 mt-md-0 mt-lg-0 pt-md-0 pt-lg-0">Semi-Sweet Chocolate Chunk</h1>
                    <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                    <div>
                        <a href="{{route('get-productdetailspage')}}" class="btn btn-outline-light me-2">Learn More</a>
                        <a href="{{route('get-packmenupage')}}" class="btn btn-light">Order Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mobile Product Section --}}
<section class="content-section-mobile d-block d-md-none">
    <div class="container pb-4">
        <h1 class="secondaryheading-mobile pt-3">Our Yummers</h1>
        <div class="row g-2 pt-4">
            <div class="col-6">
                <img src="{{asset('images/Chocolatebrownie.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-6">
                <h1 class="mobile-product-heading pt-3">Semi-Sweet Chocolate Chunk</h1>
                <a style="color: #000" href="{{route('get-productdetailspage')}}">Learn More</a>
            </div>
        </div>
        <div class="row g-2 pt-4">
            <div class="col-6">
                <h1 class="mobile-product-heading pt-3">Semi-Sweet Chocolate Chunk</h1>
                <a style="color: #000" href="{{route('get-productdetailspage')}}">Learn More</a>
            </div>
            <div class="col-6">
                <img src="{{asset('images/Chocolatebrownie.jpg')}}" class="img-fluid" alt="">
            </div>
        </div>
        <div class="row g-2 pt-4">
            <div class="col-6">
                <img src="{{asset('images/Chocolatebrownie.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-6">
                <h1 class="mobile-product-heading pt-3">Semi-Sweet Chocolate Chunk</h1>
                <a style="color: #000" href="{{route('get-productdetailspage')}}">Learn More</a>
            </div>
        </div>
        <div class="row g-2 pt-4">
            <div class="col-6">
                <h1 class="mobile-product-heading pt-3">Semi-Sweet Chocolate Chunk</h1>
                <a style="color: #000" href="{{route('get-productdetailspage')}}">Learn More</a>
            </div>
            <div class="col-6">
                <img src="{{asset('images/Chocolatebrownie.jpg')}}" class="img-fluid" alt="">
            </div>
        </div>
        <div class="row g-2 pt-4">
            <div class="col-6">
                <img src="{{asset('images/Chocolatebrownie.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-6">
                <h1 class="mobile-product-heading pt-3">Semi-Sweet Chocolate Chunk</h1>
                <a style="color: #000" href="{{route('get-productdetailspage')}}">Learn More</a>
            </div>
        </div>
    </div>

</section>
@include('client.partials.footer')

@endsection
