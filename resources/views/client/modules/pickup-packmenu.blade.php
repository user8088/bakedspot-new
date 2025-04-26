@extends('client.layouts.main')

@section('page')
<section class="pack-menu pb-5">
    <div class="container pt-5">
        <div class="row">
            <h1 class="heading-black pb-3">Choose Your Pack</h1>
            <p class="text-center mb-5">Select a pack size and then pick your favorite flavors</p>

            <div class="col-md-6 mb-4">
                <a href="{{ route('pickup-pack-four') }}" class="text-decoration-none">
                    <div class="card pack-card shadow">
                        <img src="{{ asset('images/pk-4.png') }}" class="card-img-top" alt="Pack of 4">
                        <div class="card-body text-center">
                            <h2 class="card-title fw-bold text-dark">Pack of 4</h2>
                            <p class="card-text text-muted">Perfect for a small group</p>
                            <p class="card-price text-dark fw-bold">Starting from PKR 1,400</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="{{ route('pickup-pack-eight') }}" class="text-decoration-none">
                    <div class="card pack-card shadow">
                        <img src="{{ asset('images/pk-8.png') }}" class="card-img-top" alt="Pack of 8">
                        <div class="card-body text-center">
                            <h2 class="card-title fw-bold text-dark">Pack of 8</h2>
                            <p class="card-text text-muted">Perfect for a party</p>
                            <p class="card-price text-dark fw-bold">Starting from PKR 2,800</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .pack-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .pack-card:hover {
        transform: translateY(-10px);
    }
    .card-price {
        font-size: 1.2rem;
        margin-top: 10px;
    }
    .shadow {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
