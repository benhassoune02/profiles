<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegant Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/loginClient.css') }}">
</head>
<body>
    @include('client.navbar')
    <div class="login-wrapper">
        <div class="login-box">
            <h2>Login</h2>
            
            @if(session('error') && session('error') !== 'PLease login first')
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" action="{{route('check_client')}}" method="post">
                @csrf
                <div class="input-field">
                    <input type="email" id="username" name="email" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Sign In</button>
                <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">REGISTER</a>.</p>
            </form>
        </div>
    </div>
</body>
</html>