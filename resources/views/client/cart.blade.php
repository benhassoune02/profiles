<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
</head>
<body>
    @include('client.navbar')
    <div class="container container-cart">

        @if(session('success'))
            <div class="alert custom-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert custom-alert alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="close custom-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>        
            </div>
        @endif
        
        <h2 class="cart-title my-4" style="font-size: 48px;">Profiles in Cart</h2>

        @php
            $totalPrice = 0; 
        @endphp

        @if($carts && !$carts->isEmpty())
            @foreach ($carts as $cart)
                @php
                $client_id = Auth::guard('client')->id(); 
                @endphp

            @if(!($cart->profile->isPurchased($client_id) || $cart->profile->isPurchasedInCart($client_id)))
                <div class="cart-item">
                    <h4>{{ $cart->profile->name }}</h4>
                    <p>Price: ${{ $cart->profile->price }}</p>

                    <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">DELETE</button>
                    </form>

                    @php
                        $totalPrice += $cart->profile->price;
                    @endphp
                </div>
            @endif
            @endforeach
    </div>
    <!-- Check if totalPrice is greater than 0 to display the payment option -->
    <div class="selected">
        @if($totalPrice > 0)
        <div class="select-profiles-section">
            <h2 class="section-title">Select Profiles to Purchase</h2>
            <p class="checklist-title">Click the checkboxes for your favorite profiles you want to purchase:</p>
            <form id="paymentForm" action="{{ route('payment_total') }}" method="POST">
                @csrf
                @foreach ($carts as $cart)
                    @if(!$cart->profile->isPurchased($client_id) && !$cart->profile->isPurchasedInCart($client_id))
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="cart_ids[]" value="{{ $cart->id }}" id="cart_{{ $cart->id }}" data-price="{{ $cart->profile->price }}">
                            <label class="form-check-label" for="cart_{{ $cart->id }}" style="font-size: 20px;">
                                {{ $cart->profile->name }} - ${{ $cart->profile->price }}
                            </label>
                        </div>
                    @endif
                @endforeach
                <div class="select-all-container">
                    <input type="checkbox" id="select-all" />
                    <label for="select-all">Select All</label>
                </div>
                <p class="total-price">Total Price Of All Profiles : ${{ number_format($totalPrice, 2) }}</p>
                <button type="submit" class="btn btn-paypal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" aria-hidden="true" focusable="false">
                        <path d="M111.4 295.9c-3.5 19.2-17.4 108.7-21.5 134-.3 1.8-1 2.5-3 2.5H12.3c-7.6 0-13.1-6.6-12.1-13.9L58.8 46.6c1.5-9.6 10.1-16.9 20-16.9 152.3 0 165.1-3.7 204 11.4 60.1 23.3 65.6 79.5 44 140.3-21.5 62.6-72.5 89.5-140.1 90.3-43.4 .7-69.5-7-75.3 24.2zM357.1 152c-1.8-1.3-2.5-1.8-3 1.3-2 11.4-5.1 22.5-8.8 33.6-39.9 113.8-150.5 103.9-204.5 103.9-6.1 0-10.1 3.3-10.9 9.4-22.6 140.4-27.1 169.7-27.1 169.7-1 7.1 3.5 12.9 10.6 12.9h63.5c8.6 0 15.7-6.3 17.4-14.9 .7-5.4-1.1 6.1 14.4-91.3 4.6-22 14.3-19.7 29.3-19.7 71 0 126.4-28.8 142.9-112.3 6.5-34.8 4.6-71.4-23.8-92.6z"/>
                    </svg>
                    Pay With Paypal
                </button>
            </form>
            <button id="bankTransferBtn" class="btn btn-info mt-4">Pay with Bank Transfer</button>
            @else
            <p class="text-center mt-4" style="margin-left: 610px; color:rgb(105, 105, 105); font-style: italic ;">There is no profile in the cart.</p>
        @endif
    @endif
    </div> 
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectAllCheckbox = document.getElementById('select-all');
            var profileCheckboxes = document.querySelectorAll('.form-check-input');
            
            selectAllCheckbox.addEventListener('change', function() {
                profileCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotalPrice();
            });
            
            profileCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateTotalPrice);
            });
            
            function updateTotalPrice() {
                var totalPrice = 0;
                profileCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        var price = parseFloat(checkbox.getAttribute('data-price'));
                        totalPrice += price;
                    }
                });
                document.querySelector('.total-price').textContent = 'Total Price Of All Profiles : $' + totalPrice.toFixed(2);
            }
        });
        </script>
        <script>
            document.getElementById('bankTransferBtn').addEventListener('click', function() {
                var form = document.getElementById('paymentForm');
                form.action = '{{ route('banktransfer_form') }}';
                form.method = 'GET'; // Ensure this matches the route's method
                form.submit();
            });
        </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>