@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="container shadow pt-5 p-5" style="background-color: #fff; border-radius: 30px;">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="font-size: 12px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <h1 class="heading-black-small pb-5 pt-5">Add New Sector</h1>

        <form action="{{route('add-newsector')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Sector Name</label>
                <input type="text" class="form-control" id="sector_name" name="sector_name" value="{{ old('sector_name') }}">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Delivery Charges</label>
                <input type="number" class="form-control" id="delivery_charges" name="delivery_charges" value="{{ old('delivery_charges') }}"  required>
            </div>
            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-main px-3 py-3">Add Sector</button>
            </div>
        </form>
    </div>
</div>
@endsection
