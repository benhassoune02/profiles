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

        .btn-confirm, .btn-cancel {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            display: inline-block;
            margin-right: 5px;
        }

        .btn-confirm {
            background-color: #4CAF50; 
        }

        .btn-cancel {
            background-color: #a5190f; 
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
        
        <h1>All Bank Transfers</h1>

        <table>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Total Amount</th>
                    <th>Payment Reference</th>
                    <th>Bank Name</th>
                    <th>Account Number</th>
                    <th>Payment Status</th>
                    <th>Confirming</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($banktransfers as $transfer)
                    <tr>
                        <td>{{ $transfer->order_number }}</td>
                        <td>{{ $transfer->client_id }}</td>
                        <td>{{ $transfer->client->name }}</td> 
                        <td>${{ number_format($transfer->total_amount, 2) }}</td>
                        <td>{{ $transfer->payment_reference }}</td>
                        <td>{{ $transfer->bank_name }}</td>
                        <td>{{ $transfer->account_number }}</td>
                        <td>{{ $transfer->payment_status }}</td>
                        <td>
                            @if($transfer->payment_status === 'pending' || $transfer->payment_status === 'cancelled')
                                <a href="{{ route('banktransfers.confirm', $transfer->id) }}" class="btn-confirm" onclick="return confirm('Are you sure you want to confirm this transfer?');">Confirm</a>
                            @endif
                        
                            @if($transfer->payment_status === 'confirmed')
                                <a href="{{ route('banktransfers.cancel', $transfer->id) }}" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this transfer?');">Cancel</a>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('banktransfers.delete', $transfer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transfer?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" style="background-color: #ff0000; color: #ffffff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>