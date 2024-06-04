<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/purchased_profile.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @include('admin.sidebar')
    <div id="container">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        
        <h1>Purchased Profiles</h1>
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Profile Purchased Name</th>
                    <th>Profile Purchased Address</th>
                    <th>Profile Purchased Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartProfiles as $cartProfile)
                    <tr>
                        <td>{{ $cartProfile->client->name }}</td>
                        <td>{{ $cartProfile->client->email }}</td>
                        <td>{{ $cartProfile->profile->name }}</td>
                        <td>{{ $cartProfile->profile->address }}</td>
                        <td>{{ $cartProfile->profile->phone_number }}</td>
                        <td>
                            <form action="{{ route('delete_cart_purchased_profile', $cartProfile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this profile?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>