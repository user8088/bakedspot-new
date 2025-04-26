@extends('client.layouts.main')

@section('page')
<section class="start-order">
    <div class="container">
        <div class="row">
            <h1 class="heading-black pt-5 pb-3">Start Your Order</h1>
            <div class="col-lg-6 mb-4">
                <a href="{{route('get-packmenupage')}}">
                <div class="card order-card shadow">
                    <img src="{{ asset('images/b17.png') }}" width="100" alt="Delivery" class="card-img-top">
                    <div class="card-body text-center">
                        <h2 class="card-title fw-bold">Delivery</h2>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-6 mb-4">
                <a href="{{route('pickup-packmenupage')}}">
                <div class="card order-card shadow">
                    <img src="{{ asset('images/sectors.png') }}" width="100" alt="Pickup" class="card-img-top">
                    <div class="card-body text-center">
                        <h2 class="card-title fw-bold">Pick Up</h2>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .order-card {
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        background-color: #ffb6c1;
    }
    .bg-pink {
        background-color: #ffb6c1;
    }
    .shadow {
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
