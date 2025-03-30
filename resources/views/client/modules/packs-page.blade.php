@extends('client.layouts.main')
@section('page')
<section class="packs-menu">
    <div class="container py-4">
        <h1 class="heading-black">Brownie Packs</h1>
        <div class="row pt-3">
            <!-- First Card -->

            <div class="col-md-6">
                <a href="{{route('get-packfourpage')}}">
                <div class="card border-0">
                    <img src="{{asset('images/pk-4.png')}}" class="card-img-top" alt="Delicious Dessert">
                    <div class="card-body">
                        <h1 class="card-title heading-black-small">Pack of Four</h1>
                        <p class="card-text">PKR 1000</p>
                    </div>
                </div>
            </a>
            </div>


            <!-- Second Card -->
            <div class="col-md-6">
                <div class="card border-0">
                    <img src="{{asset('images/pk-8.png')}}" class="card-img-top" alt="Delicious Dessert">
                    <div class="card-body">
                        <h1 class="card-title heading-black-small">Pack of Eight</h1>
                        <p class="card-text">PKR 3000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
