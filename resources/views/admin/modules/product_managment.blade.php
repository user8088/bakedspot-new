@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="row">
        <div class="col-md-4">
            <a href="{{route('get-newproductpage')}}">
            <div class="stats-card panes shadow">
                <div>
                    <h6>Add New Product</h6>
                </div>
                <div class="icon">
                    <img alt="Logo" width="40" src="{{asset('icons/add.png')}}" />
                </div>
            </div>
        </a>
        </div>
    </div>
    <div class="col-md-10 content">
    <div class="row pt-5" >
        <div class="container holder py-5 shadow" style="background-color: #fff;">
            <h1 class="heading-black-small text-center pb-3">My Products</h1>
            @foreach ($products as $product)
                <div class="row pb-4 border-bottom">
                    <div class="col-lg-2 d-flex align-content-center justify-content-center">
                        <img src="{{asset('images/dummy-product-1.png')}}" width="100" alt="">
                    </div>
                    <div class="col-lg-5 d-flex ">
                        <h1 class="heading-black-smaller pt-4">{{$product->name}}</h1>
                    </div>
                    <div class="col-lg-2 align-content-center justify-content-center">
                        <a href="{{route('get-editpage', $product->id)}}" class="btn btn-main py-2 px-3" >Edit Product</a>
                    </div>
                    <div class="col-lg-3 align-content-center justify-content-center">
                    <form action="{{ route('delete-product', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-main py-2 px-3">Delete</button>
                    </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
</div>
@endsection
