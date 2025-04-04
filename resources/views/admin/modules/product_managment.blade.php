@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="row">
        <div class="col-md-4">
            <a href="{{route('get-newproductpage')}}">
                <div class="stats-card panes shadow">
                    <div class="row">
                        <div class="col-10 col-lg-10 col-md-10">
                            <h6>Add New Product</h6>
                        </div>
                        <div class="col-2 col-lg-2 col-md-2 d-flex justify-content-center align-items-center">
                            <img alt="Logo" width="30" src="{{asset('icons/add.png')}}" />
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-10 content">
        <div class="row pt-5">
            <div class="container holder py-5 shadow" style="background-color: #fff;">
                <h1 class="heading-black-small text-center pb-3">My Products</h1>

                @foreach ($products as $product)
                    <div class="row pb-4 border-bottom align-items-center">
                        <div class="col-12 col-md-2 d-flex justify-content-center mb-3 mb-md-0">
                            <img src="{{ asset('images/dummy-product-1.png') }}" width="100" alt="">
                        </div>

                        <div class="col-12 col-md-5 text-center text-md-start mb-3 mb-md-0">
                            <h1 class="heading-black-smaller">{{ $product->name }}</h1>
                        </div>

                        <div class="col-6 col-md-2 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                            <a href="{{ route('get-editpage', $product->id) }}" class="btn btn-main py-2 px-3 w-100 w-md-auto">Edit</a>
                        </div>

                        <div class="col-6 col-md-3 d-flex justify-content-center justify-content-md-start">
                            <form action="{{ route('delete-product', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-main py-2 px-3 w-100 w-md-auto">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
