<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Store</title>
    <link rel="stylesheet" href="{{ asset('css/profilesClient.css') }}">
</head>
<body>
    @include('client.navbar')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (Auth::guard('client')->check())
            <h1>Welcome, {{ Auth::guard('client')->user()->name }}!</h1>
        @else
            <p>Client is not logged in.</p>
        @endif        
        <div>
            <p style="color: rgb(125, 125, 125)">Explore our diverse selection of profiles as you need. Each profile comes with valuable informations to meet your requirements. Simply browse through the available profiles, choose the one that interests you, and proceed to purchase. Upon completing the purchase, you will gain access to comprehensive details and data associated with the selected profile. It's a seamless process designed to provide you with the informations you desire. Start your journey now and unlock the insights you've been looking for!</p>
        </div>

        <!-- Purchased Profiles Section -->
        <h2 class="section-title">Your Purchased Profiles</h2>
        <div class="profile-cards">
            @php
                $hasPurchasedProfiles = false;
            @endphp
            @foreach ($profiles as $profile)
                @if($profile->isPurchased(Auth::guard('client')->id()) || $profile->isPurchasedInCart(Auth::guard('client')->id()) || $profile->isConfirmedViaBankTransfer(Auth::guard('client')->id()))
                    @php
                        $hasPurchasedProfiles = true;
                    @endphp
                    <div class="card">
                        <h2>{{ $profile->name }}</h2>
                        <p>Name: {{ $profile->name }}</p>
                        <p>Email: {{ $profile->email }}</p>
                        <p>Phone: {{ $profile->phone_number }}</p>
                        <p>Address: {{ $profile->address }}</p>
                    </div>
                @endif
            @endforeach
        
            @if(!$hasPurchasedProfiles)
                <div class="no-purchased-message">
                    <p>You still haven't purchased any profile. Once you buy profiles , they will start displaying here with all informations !</p>
                </div>
            @endif
        </div>

        <!-- Available Profiles Section -->
        <h2 class="section-title" style="margin-top: 50px;">Available Profiles For Selling!</h2>
        <div class="profile-cards">
            @php $availableForSale = false; @endphp
                @foreach ($profiles as $profile)
                    @if(!$profile->isPurchased(Auth::guard('client')->id()) && !$profile->isPurchasedInCart(Auth::guard('client')->id()) && !$profile->isPartOfPendingBankTransfer(Auth::guard('client')->id()) && !$profile->isConfirmedViaBankTransfer(Auth::guard('client')->id()))
                        @php $availableForSale = true; @endphp
                        <div class="card">
                            <h2>{{ $profile->name }}</h2>
                            <p>Price: {{ $profile->price }} $</p>
                            <div style="display: flex;">
                                @if(!$profile->isInCart(Auth::guard('client')->id()))
                                    <form action="{{ route('cart.add', $profile->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="save-btn" style="margin-left: 70px;">Add to cart</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
    
                @if(!$availableForSale)
                    <div class="no-available-profiles">
                        <p>Currently, there are no profiles available for sale.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>