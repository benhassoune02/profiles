<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Purchase</title>
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }

        .profile-name {
            font-size: 24px;
            margin: 10px 0;
        }

        .profile-price {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        .paywithpaypal {
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            text-decoration: none;
        }

        .paywithpaypal:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    @include('client.navbar')
    <div class="content-wrapper">
        <div class="profile-card">
            <h2 class="profile-name">{{ $profile->name }}</h2>
            <p class="profile-price">Price: ${{ $profile->price }}</p>

            <form action="{{ route('payment') }}" method="post">
                @csrf
                <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                <input type="hidden" name="amount" value="{{ $profile->price }}">
                <button type="submit" class="paywithpaypal">Pay with PayPal</button>
            </form>
        </div>
    </div>
</body>
</html>