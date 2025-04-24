<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartOffcanvasLabel">Your Bag</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="cartItems">
            <!-- Cart items will go here -->
            {{-- <p class="text-center">Your bag is empty.</p> --}}
            <div class="row cart-item pb-3 pt-3 border-top">
                <div class="col-lg-3">
                    <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-3">
                    <p class="pt-2">Pack of 4</p>
                </div>
                <div class="col-lg-3">
                    <p class="pt-2"><b>PKR 1000</b></p>
                </div>
            </div>
            <div class="row cart-item pb-3 pt-3 border-top">
                <div class="col-lg-3">
                    <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-3">
                    <p class="pt-2">Pack of 4</p>
                </div>
                <div class="col-lg-3">
                    <p class="pt-2"><b>PKR 1000</b></p>
                </div>
            </div>
            <div class="row cart-item pb-3 pt-3 border-top">
                <div class="col-lg-3">
                    <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-3">
                    <p class="pt-2">Pack of 4</p>
                </div>
                <div class="col-lg-3">
                    <p class="pt-2"><b>PKR 1000</b></p>
                </div>
            </div>
            <div class="row cart-item pb-3 pt-3 border-top">
                <div class="col-lg-3">
                    <img src="{{asset('images/pk-4.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-3">
                    <p class="pt-2">Pack of 4</p>
                </div>
                <div class="col-lg-3">
                    <p class="pt-2"><b>PKR 1000</b></p>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-main w-100">Checkout</button>
        </div>
    </div>
</div>
