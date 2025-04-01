@extends('client.layouts.main')
@section('page')
<section class="pack8">
    <div class="container pt-5 pb-5">
        <div class="row">
            <!-- Pink Container -->
            <div class="col-lg-6 pack-background position-relative">
                <div class="container-box-eight" id="selected-items-container">
                    <!-- Selected images will appear here -->
                </div>
            </div>
            <!-- Selection Panel -->
            <div class="col-lg-6">
                <h1 class="heading-black-small pb-3 pt-3 ps-0 ps-md-5">Select 8 Flavors</h1>
                <div class="row ps-0 ps-md-5">
                    @php
                        $flavors = [
                            ['name' => 'Red Velvet Brownie', 'calories' => 690,'price' => 250, 'image' => 'dummy-product-1.png'],
                            ['name' => 'Triple Chocolate Brownie', 'calories' => 880,'price' => 250, 'image' => 'dummy-product-2.png'],
                            ['name' => 'Cookie Dough Brownie', 'calories' => 770, 'price' => 250,'image' => 'dummy-product.png'],
                            ['name' => 'Peanut Butter Brownie', 'calories' => 880,'price' => 250, 'image' => 'dummy-product.png'],
                            ['name' => 'Lemon Cheese Cake Brownie', 'calories' => 660,'price' => 250, 'image' => 'dummy-product.png'],
                            ['name' => 'Classic Brownie', 'calories' => 910,'price' => 250, 'image' => 'dummy-product.png'],
                        ];
                    @endphp

                    @foreach ($flavors as $flavor)
                        <div class="d-flex align-items-center justify-content-between border-bottom my-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/' . $flavor['image']) }}" class="flavor-img me-3" width="50">
                                <div>
                                    <strong>{{ $flavor['name'] }}</strong><br>
                                    <span>{{ $flavor['calories'] }} cal</span>
                                </div>
                            </div>
                            <div class="counter d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-dark decrease" data-name="{{ $flavor['name'] }}" data-price="{{ $flavor['price'] }}" data-image="{{ asset('images/' . $flavor['image']) }}">-</button>
                                <span class="mx-2 quantity" data-name="{{ $flavor['name'] }}">0</span>
                                <button class="btn btn-sm btn-outline-dark increase" data-name="{{ $flavor['name'] }}" data-price="{{ $flavor['price'] }}" data-image="{{ asset('images/' . $flavor['image']) }}">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-end text-md-end text-center sticky-bottom pb-3">
                    <a class="btn btn-order show mt-3 p-3 disabled" href="#" id="add-to-bag">Add 8 More - PKR 0.00</a>
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
