<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container_payment_container {
            max-width: 600px;
            margin-top: 110px;
            margin-left: 430px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .payment-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: none;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
@include('client.navbar')
<div class="container_payment_container">
    <div class="row payment-row">
        <div class="payment-wrapper">
            <div class="payment-panel">
                <div class="panel-body">
                    <h1 class="payment-title">Payment Gateway</h1>
                    @if(Session::has('success'))
                        <div class="alert alert-success payment-alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert alert-danger payment-alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
  
                    <form role="form" action="{{ route('stripe.post', ['id' => $profile->id]) }}" method="post" class="payment-form require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                        <input type="hidden" name="amount" value="{{ $profile->price * 100 }}">

                        <div class="form-group">
                            <label class="control-label">Name on Card</label> 
                            <input class="form-control" type='text'>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Card Number</label> 
                            <input autocomplete='off' class="form-control" type='text'>
                        </div>

                        <div class="form-group">
                            <label class="control-label">CVC</label> 
                            <input autocomplete='off' class="form-control" placeholder='ex. 311' type='text'>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Expiration Month</label> 
                            <input class="form-control" placeholder='MM' type='text'>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Expiration Year</label> 
                            <input class="form-control" placeholder='YYYY' type='text'>
                        </div>

                        <div class="form-submit">
                            <button class="btn btn-primary" type="submit">Pay</button>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    $(function() {
        var $form = $(".require-validation");
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");

        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('.card-number');

        $('form.require-validation').on('submit', function(e) {
            e.preventDefault();

            $form.find('.error').addClass('hide').find('.alert').text('');

            if (!$form.data('cc-on-file')) {
                stripe.createPaymentMethod('card', card).then(function(result) {
                    if (result.error) {
                        $form.find('.error').removeClass('hide').find('.alert').text(result.error.message);
                    } else {
                        var paymentMethodId = result.paymentMethod.id;

                        // Call your server to handle Payment Intent confirmation
                        $.ajax({
                            url: "{{ route('stripe.post', ['id' => $profile->id]) }}", // Adjust the route
                            type: 'POST',
                            data: { payment_method: paymentMethodId, amount: {{ $profile->price * 100 }} },
                            success: function(response) {
                                // Handle success, if needed
                                console.log(response);
                            },
                            error: function(error) {
                                // Handle error, if needed
                                console.error(error);
                            }
                        });
                    }
                });
            }
        });
    });
</script>


</html>