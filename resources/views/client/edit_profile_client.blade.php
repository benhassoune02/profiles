<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/edit_profile_client.css')}}">
    <title>Edit Account</title>
</head>
<body>
    @include('client.navbar')

    <div style="margin-top: 135px;">
        <h2>Edit Your Account </h2>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form action="{{ route('update_profile') }}" method="post">
            @csrf
            @method('POST')

            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ old('email', $client->email) }}" required>

            <label for="password">New Password :</label>
            <input type="password" name="password">

            <label for="password_confirmation">Confirm New Password :</label>
            <input type="password" name="password_confirmation">

            <button type="submit">Update My Account </button>
        </form>
    </div>
</body>
</html>