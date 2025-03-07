@extends('client.layouts.main')
@section('page')

{{-- Full-Screen Video Section --}}
<section class="video-section">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="https://cdn.pixabay.com/video/2021/11/18/98283-647561752_large.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="overlay-content">
        <h1 class="secondaryheading" style="color: white;">Best brownies in town.</h1>
        <a href="#" class="btn btn-main py-3 px-3">
            <span class="fw-bold button-text">Order Now</span>
        </a>
    </div>
</section>

{{-- Products Section (or any other section) --}}
<section class="content-section position-relative">
    <div class="container">
        <h1 class="mainheading pb-5 mb-5">Our Yummers</h1>
        <div class="container home-brownie-container  position-relative">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                    <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <button class="btn btn-light">Order Now</button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="container home-brownie-container  position-relative mt-5 pt-5">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 ps-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <button class="btn btn-light">Order Now</button>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                </div>
            </a>
        </div>
        <div class="container home-brownie-container  position-relative mt-5 pt-5">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                    <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <button class="btn btn-light">Order Now</button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="container home-brownie-container  position-relative mt-5 pt-5">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 ps-5 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <button class="btn btn-light">Order Now</button>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                </div>
            </a>
        </div>
        <div class="container home-brownie-container  position-relative mt-5 pt-5">
            <a href="" style="text-decoration: none;">
                <div class="row pt-3 pb-3 align-items-center justify-content-center text-center text-lg-start position-relative">
                    <div class="col-lg-6 d-flex justify-content-center position-relative">
                        <img src="{{ asset('images/dummy-product.png') }}" class="img-fluid cookie-image" alt="">
                    </div>
                    <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center text-white">
                        <h1 class="fw-bold">Semi-Sweet Chocolate Chunk</h1>
                        <p>Chocolate chip, but make it chunky—a delicious cookie filled with irresistible semi-sweet chocolate chunks and a sprinkle of flaky sea salt.</p>
                        <div>
                            <button class="btn btn-outline-light me-2">Learn More</button>
                            <button class="btn btn-light">Order Now</button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

</section>




@endsection
