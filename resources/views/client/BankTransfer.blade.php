<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bank_transfer.css') }}">
    <title>Bank Transfer Payment</title>
</head>
<body>
    @include('client.navbar')

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>Bank Transfer Information</h2>
        <p>Please fill in the details below to complete your purchase via bank transfer.</p>
        <div style="display: flex;">
            <div class="bank-details-section">
                <h3 style="margin-left: 35px;">Our Bank Details</h3>
                <p><strong>Bank Name:</strong> CIH</p>
                <p><strong>Account Name:</strong> ILYAS</p>
                <p><strong>Account Number:</strong> 9842367-412549-784591</p>
                <p><strong>SWIFT/BIC:</strong>...</p>
                <p><strong>Branch:</strong> Your Branch Name / Address</p>
            </div>


            <div class="form-section" style="padding-right: 60px;">

                <form action="{{ route('submitbank_transfer') }}" method="POST">
                    @csrf 
                    <div class="form-group" style="padding-right: 20px;">
                        <label for="payment_reference" style="padding-right: 20px;">Your Payment Reference</label>
                        <input type="text" class="form-control" id="payment_reference" name="payment_reference" required>
                    </div>

                    <div class="form-group"  style="padding-right: 20px;">
                        <label for="bank_name"  style="padding-right: 20px;">Your Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>

                    <div class="form-group"  style="padding-right: 20px;">
                        <label for="account_number"  style="padding-right: 20px;">Your Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>

                    <div class="form-group"  style="padding-right: 20px;">
                        <label  style="padding-right: 20px;">Total Amount: </label>
                        <span>{{ session('bank_transfer.total_price') ? '$'.number_format(session('bank_transfer.total_price'), 2) : 'Error: Total amount not found' }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary"  style="padding-right: 20px;">Submit Bank Transfer</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>