<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <title>Laravel PayPal Integration</title>
  
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />

        <!-- Custom Styles -->
        <style>
            html, body {
                background-color: #f2f2f2;
                color: #555;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding-bottom: 40px;
            }

            .paywithpaypal {
                font-size: 16px;
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .paywithpaypal:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    <h1>PayPal Payment</h1>
                </div>
                  
                <a href="https://www.paypal.com/in/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup','WIPaypal','width=1060,height=700'); return false;">
                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" alt="PayPal Logo">
                </a>

                <div style="margin-top: 30px;">
                    <form action="{{route('payment')}}" method="post">
                        @csrf
                        <input type="hidden" name="amount" value="200">
                        <button type="submit" class="paywithpaypal">Pay with PayPal</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>