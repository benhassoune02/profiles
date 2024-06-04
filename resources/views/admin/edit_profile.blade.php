<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/edit_profiles.css')}}">
    <title>Edit Profile</title>
</head>
<body>
    @include('admin.sidebar')
    <div class="form-container">
        <h1>Edit Profile</h1>
        <form action="{{ route('profile.update', $profile->id) }}" method="POST">
            @csrf
            @method('POST')

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $profile->name }}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $profile->email }}" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ $profile->phone_number }}" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="{{ $profile->address }}" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="{{ $profile->price }}" step="0.0001" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>