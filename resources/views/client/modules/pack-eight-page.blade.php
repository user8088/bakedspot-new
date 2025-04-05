@extends('client.layouts.main')

@section('page')
<section class="pack4">
    <div class="container pt-0 pt-md-5 pb-0 pb-md-5">
        <div class="row">
            <!-- Pink Container -->
            <div class="col-lg-6 pack-background position-relative">
                <div class="container-box" id="selected-items-container">
                    <!-- Selected images will appear here -->
                </div>
            </div>
            <!-- Selection Panel -->
            <div class="col-lg-6">
                <h1 class="heading-black-small pb-3 pt-3 ps-0 ps-md-5">Select 4 Flavors</h1>
                <div class="row ps-0 ps-md-5">
                    @foreach ($products as $product)
                        <div class="d-flex align-items-center justify-content-between border-bottom my-2">
                            <div class="d-flex align-items-center">
                                @if ($product->images->isNotEmpty() && $product->images->first()->pack_image_url)
                                {{-- {{dd($product->images->first()->pack_image_ur)}} --}}
                                <img src="{{asset($product->images->first()->pack_image_url) }}" class="flavor-img me-3" width="50">
                                @else
                                    <img src="{{ asset('images/default-image.png') }}" class="flavor-img me-3" width="50">
                                @endif
                                <div>
                                    <strong>{{ $product->name }}</strong><br>
                                    <span>PKR. {{ $product->price }}</span>
                                </div>
                            </div>
                            <div class="counter d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-dark decrease" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->images->isNotEmpty() && $product->images->first()->pack_image_url ? asset($product->images->first()->pack_image_url)  : asset('images/default-image.png') }}">-</button>
                                <span class="mx-2 quantity" data-name="{{ $product->name }}">0</span>
                                <button class="btn btn-sm btn-outline-dark increase" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->images->isNotEmpty() && $product->images->first()->pack_image_url ? asset($product->images->first()->pack_image_url) : asset('images/default-image.png') }}">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-end text-md-end text-center sticky-bottom pb-3">
                    <a class="btn btn-order show mt-3 p-3 disabled" href="#" id="add-to-bag">Add 4 More - PKR 0.00</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('selected-items-container');
    const addToBagButton = document.getElementById('add-to-bag');
    let totalPrice = 0;
    let totalSelected = 0;

    function updateButton() {
        let remaining = 8 - totalSelected;
        if (remaining === 0) {
            addToBagButton.innerText = `Add to Bag - PKR ${totalPrice.toFixed(2)}`;
            addToBagButton.classList.remove('disabled');
        } else {
            addToBagButton.innerText = `Add ${remaining} More - PKR ${totalPrice.toFixed(2)}`;
            addToBagButton.classList.add('disabled');
        }
    }

    document.querySelectorAll('.increase').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const price = parseInt(this.getAttribute('data-price'));
            const imageSrc = this.getAttribute('data-image');
            const quantitySpan = document.querySelector(`.quantity[data-name="${name}"]`);
            let quantity = parseInt(quantitySpan.innerText);

            if (quantity < 8 && totalSelected < 8) {
                quantity++;
                quantitySpan.innerText = quantity;
                totalSelected++;
                totalPrice += price;

                let img = document.createElement('img');
                img.src = imageSrc;
                img.classList.add('selected-img');
                img.setAttribute('data-name', name);
                container.appendChild(img);
                updateButton();
            }
        });
    });

    document.querySelectorAll('.decrease').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const price = parseInt(this.getAttribute('data-price'));
            const quantitySpan = document.querySelector(`.quantity[data-name="${name}"]`);
            let quantity = parseInt(quantitySpan.innerText);

            if (quantity > 0) {
                quantity--;
                quantitySpan.innerText = quantity;
                totalSelected--;
                totalPrice -= price;

                const images = document.querySelectorAll(`.selected-img[data-name="${name}"]`);
                if (images.length > 0) {
                    images[images.length - 1].remove();
                }
                updateButton();
            }
        });
    });

    updateButton();
});
</script>

@endsection
