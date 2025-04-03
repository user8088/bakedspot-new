@extends('admin.layouts.main')

@section('page')
    <div class="col-lg-10 content">
        <div class="container shadow pt-5 p-5" style="background-color: #fff; border-radius: 30px;">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

            <h1 class="heading-black-small pb-5 pt-5">Edit General Details</h1>

            <form action="{{ route('edit-product', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Information -->
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}">
                </div>

                <div class="mb-3">
                    <label for="heading" class="form-label">Heading</label>
                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $product->heading) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Allergy Information -->
                <div class="mb-3">
                    <label for="allergy_info" class="form-label">Allergy Information</label>
                    <textarea class="form-control" id="allergy_info" name="allergy_info">{{ old('allergy_info', $product->allergy_info) }}</textarea>
                </div>

                <!-- Nutritional Details -->
                <h1 class="heading-black-small pb-5 pt-5">Edit Nutritional Details</h1>
                <div class="row">
                    @foreach(['calories', 'fat', 'carbohydrates', 'protein', 'sugar', 'fiber', 'sodium'] as $nutrient)
                        <div class="col-md-4 mb-3">
                            <label for="{{ $nutrient }}" class="form-label">{{ ucfirst($nutrient) }}</label>
                            <input type="number" class="form-control" id="{{ $nutrient }}" name="{{ $nutrient }}"
                                value="{{ old($nutrient, optional($product->nutrition)->$nutrient) }}">
                        </div>
                    @endforeach
                </div>

                <!-- Theme Color Code -->
                <div class="mb-3">
                    <label for="theme_color" class="form-label">Theme Color Code</label>
                    <input type="text" class="form-control" id="theme_color" name="theme_color" value="{{ old('theme_color', $product->theme_color) }}">
                </div>

                <!-- Image Uploads -->
                <h1 class="heading-black-small pb-5 pt-5">Edit Product Images</h1>

                <!-- Home Image -->
                <div class="mb-3">
                    <label for="home_image" class="form-label">Home Image</label>
                    @if ($product->image && $product->image->home_image_url)
                        <div>
                            <img src="{{ asset('storage/' . $product->image->home_image_url) }}" alt="Home Image" width="100">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="home_image" name="home_image">
                </div>

                <!-- Detail Image -->
                <div class="mb-3">
                    <label for="detail_image" class="form-label">Detail Image</label>
                    @if ($product->image && $product->image->detail_image_url)
                        <div>
                            <img src="{{ asset('storage/' . $product->image->detail_image_url) }}" alt="Detail Image" width="100">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="detail_image" name="detail_image">
                </div>

                <!-- Pack Image -->
                <div class="mb-3">
                    <label for="pack_image" class="form-label">Pack Image</label>
                    @if ($product->image && $product->image->pack_image_url)
                        <div>
                            <img src="{{ asset('storage/' . $product->image->pack_image_url) }}" alt="Pack Image" width="100">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="pack_image" name="pack_image">
                </div>

                <!-- Submit Button -->
                <div class="mb-3 ">
                    <button type="submit" class="btn btn-main px-3 py-3">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
