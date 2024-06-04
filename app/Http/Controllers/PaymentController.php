<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Profile;
use App\Models\Cart;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Omnipay\Omnipay;


class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function goPayment()
    {
        return view('products.welcome');
    }


    public function pay(Request $request)
    {
        $profileId = $request->input('profile_id');
        $amount = $request->input('amount');

        try {
            $response = $this->gateway->purchase([
                'amount' => $amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('payment.success', ['profile_id' => $profileId]),
                'cancelUrl' => route('payment.error'),
            ])->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        $profileId = $request->query('profile_id');
    
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);
    
            $response = $transaction->send();
    
            if ($response->isSuccessful()) {
                $arr = $response->getData();
    
                $profile = Profile::find($profileId);
    
                if ($profile) {
                    Purchase::create([
                        'profile_id' => $profileId,
                        'client_id' => Auth::guard('client')->id(),
                        'profile_name' => $profile->name,
                        'profile_email' => $profile->email, 
                        'profile_phone_number' => $profile->phone_number,
                        'profile_address' => $profile->address, 
                        'profile_price' => $arr['transactions'][0]['amount']['total'],
                    ]);
    
                    $payment = new Payment();
                    $payment->payment_id = $arr['id'];
                    $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr['payer']['payer_info']['email'];
                    $payment->amount = $arr['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr['state'];
                    $payment->save();
    
                    return redirect()->route('client_profiles', ['id' => $profileId])->with('success', 'Payment successful. You can now access the informations the profile !');
                } else {
                    return redirect()->route('client_profiles')->with('error', 'Profile not found.');
                }
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Payment Declined!';
        }
    }

    public function error()
    {
        return 'User declined the payment!';
    }

    public function payTotal(Request $request)
    {
        // Retrieve the cart_ids input from the request
        $cartIds = $request->input('cart_ids');
    
        // Check if cart_ids is an array
        if ($cartIds === null || !is_array($cartIds)) {
            return redirect()->back()->with('error', 'Please select at least one profile to proceed with the purchase !');
        }
    
        // Store cart_ids in the session
        session(['cart_ids' => $cartIds]);
    
        // Initialize the total price
        $totalPrice = 0;
    
        // Iterate over the cart_ids array to calculate the total price
        foreach ($cartIds as $cartId) {
            $cart = Cart::find($cartId);
            if ($cart) {
                $totalPrice += $cart->profile->price;
            } else {
                Log::warning("Cart item with ID $cartId not found.");
            }
        }
    
        try {
            // Create the purchase request with the total price
            $response = $this->gateway->purchase([
                'amount' => $totalPrice,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('payment.success.total'),
                'cancelUrl' => route('payment.error'),
            ])->send();
    
            if ($response->isRedirect()) {
                return $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function successTotal(Request $request)
    {
        try {
            // Start a database transaction
            \DB::beginTransaction();

            // Retrieve cart_ids from the session instead of the request
            $cartIds = session('cart_ids');
            
            // Immediately forget the session variable to clean up after ourselves
            session()->forget('cart_ids');
    
            // If cartIds is null or not an array, handle the error appropriately
            if (empty($cartIds)) {
                \DB::rollBack();
                return redirect()->route('your.error.route')->with('error', 'Cart items not found.');
            }
    
            // Check if paymentId and PayerID are present in the request
            if ($request->filled('paymentId') && $request->filled('PayerID')) {
                $transaction = $this->gateway->completePurchase([
                    'payer_id' => $request->input('PayerID'),
                    'transactionReference' => $request->input('paymentId'),
                ]);
    
                $response = $transaction->send();
    
                if ($response->isSuccessful()) {
                    $arr = $response->getData();
    
                    // Create a new Payment record
                    $payment = new Payment();
                    $payment->payment_id = $arr['id'];
                    $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr['payer']['payer_info']['email'];
                    $payment->amount = $arr['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr['state'];
                    $payment->save();
    
                    // Update the cart entries associated with the purchased cart items
                    Cart::whereIn('id', $cartIds)->update(['ispurchased' => true]);
    
                    // Commit the transaction if everything is successful
                    \DB::commit();
    
                    return redirect()->route('client_profiles')->with('success', 'Payment successful. You can now access the informations of the profiles !');
                } else {
                    return $response->getMessage();
                }
            } else {
                return 'Payment Declined!';
            }
        } catch (\Throwable $th) {
            // Something went wrong, rollback the transaction
            \DB::rollBack();
    
            return $th->getMessage();
        }
    }

    public function errorTotal()
    {
        // Handle error logic for the total payment
        // This could involve redirecting the user to an error page or providing a message

        // Example: Returning an error message
        return redirect()->route('your.error.route')->with('error', 'Total payment declined.');
    }
}