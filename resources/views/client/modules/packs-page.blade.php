@extends('client.layouts.main')
@section('page')
<section class="packs-menu">
    <div class="container py-4 d-none d-md-block">
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
                <a href="{{route('get-packeightpage')}}">
                    <div class="card border-0">
                        <img src="{{asset('images/pk-8.png')}}" class="card-img-top" alt="Delicious Dessert">
                        <div class="card-body">
                            <h1 class="card-title heading-black-small">Pack of Eight</h1>
                            <p class="card-text">PKR 3000</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="container py-4 d-block d-md-none">
        <h1 class="heading-black-smaller">Brownie Packs</h1>
        <!-- First Row -->
        <a style="color: #000" href="{{route('get-packfourpage')}}">
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-6 col-sm-6">
                <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="Delicious Dessert">
            </div>
            <div class="col-6 col-sm-6 pt-3">
                <h1 class="heading-black-smaller">Pack of 4</h1>
                <p >PKR 1000</p>
            </div>
        </div>
        </a>
        <!-- Second Row -->
        <a style="color: #000" href="{{route('get-packeightpage')}}">
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-6 col-sm-6">
                <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="Delicious Dessert">
            </div>
            <div class="col-6 col-sm-6 pt-3">
                <h1 class="heading-black-smaller" >Pack of 4</h1>
                <p >PKR 2000</p>
            </div>
        </div>
        </a>
    </div>

</section>
@endsection
