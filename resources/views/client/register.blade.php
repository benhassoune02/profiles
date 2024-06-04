<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Sign Up</title>
</head>
<body>
    @include('client.navbar')
    <div class="form-container">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h2>Sign Up</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                       ! {{ $error }} 
                    @endforeach
                </div>
            @endif


            <input type="text" name="name" required placeholder="Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">SIGN UP</button>
            <p>Already have an account? <a href="{{ route('login_client') }}">Sign In </a>.</p>
        </form>
    </div>
</body>
</html>