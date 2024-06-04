<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    public function stripe(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        return view('client.stripepayment', compact('profile'));
    }

    public function stripePost(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found.');
        }

        $amount = $request->input('amount');

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source'=> $request->stripeToken,
                'description' => 'Payment for profile ID ' . $id,
            ]);

            Session::flash('success', 'Payment Intent created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }

        return view('client.stripepayment', compact('profile', 'intent'));
    }
}