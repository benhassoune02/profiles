<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <title>Document</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <a href="{{url('/')}}">
                    <img src="https://cdn-icons-png.flaticon.com/512/1/1176.png">
                </a>
            </div>
            <ul class="navbar-menu">
                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">HOME</a></li>
                <li class="{{ Request::is('client/client-profiles') ? 'active' : '' }}"><a href="{{ route('client_profiles') }}">PROFILES</a></li>
                <li class="{{ Request::is('client/cart') ? 'active' : '' }}"><a href="{{ route('cartview') }}">CART </a></li>
                <li class="{{ Request::is('client/edit_client_profile') ? 'active' : '' }}"><a href="{{ route('edit_profile') }}">ACCOUNT </a></li>

                @guest('client')
                <li style="margin-left: 360px;" class="{{ Request::is('login_client') ? 'active' : '' }}">
                    <a href="{{ route('login_client') }}">LOGIN</a>
                </li>
                @else
                    <li style="margin-left: 360px;">
                    <form action="{{ route('client_logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="font-size: 22px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; transition: background-color 1.1s ease, color 1.1s ease; border-radius: 5px;">
                            LOGOUT
                        </button>
                    </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</body>
</html>


