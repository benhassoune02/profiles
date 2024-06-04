<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>All Contacts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        #logout {
            padding-top: 10px;
            padding-bottom: 9px;
            margin-bottom: 4px;
        }
        .delete-button {
            color: white; 
            background-color: #ff4d4d; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: background-color 0.3s; 
            font-size: 14px;
            display: inline-flex;
            align-items: center; 
            justify-content: center; 
        }

        .delete-button:hover {
            background-color: #cc0000;
        }   

        .delete-button i {
            margin-right: 5px; 
        }

        .alert-success-custom {
            color: #155724; 
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            border-radius: 4px; 
            margin-bottom: 20px; 
            display: flex;
            align-items: center; 
            justify-content: space-between; 
        }

        .alert-success-custom i {
            margin-right: 10px; 
        }
    </style>
</head>
<body>
    @include('admin.sidebar')

    <div id="content">
        @if(session('success'))
            <div class="alert alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        <h1>All Contacts</h1>
    
        @if($contacts->isEmpty())
            <div class="alert alert-info" role="alert">
                There is no contact till now
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone_number }}</td>
                            <td>{{ $contact->address }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>
                                <form action="{{ route('delete_contact', $contact->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>