<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function addToCart(Request $request, $profileId)
    {
        $profile = Profile::find($profileId);
        if (!$profile) {
            return back()->with('error', 'Profile not found.');
        }

        if (Auth::guard('client')->check()) {
            $clientId = Auth::guard('client')->id();

            $cart = Cart::create([
                'client_id' => $clientId,
                'profile_id' => $profileId, 
                'quantity' => 1
            ]);

            return back()->with('success', 'Profile added to Cart ! ');
        }

        return redirect()->route('login_client')->with('error', 'You need to log in as a client to add items to the saved.');
    }

    public function viewCart()
    {
        if (!Auth::guard('client')->check()) {
            dd('Client is not authenticated.');
        }
    
        $clientId = Auth::guard('client')->id();
        $client = Auth::guard('client')->user(); 
    
        $carts = Cart::where('client_id', $clientId)->with('profile')->get();
    
        \Log::info('Cart items:', $carts->toArray());
    
        return view('client.cart', compact('carts', 'client'));
    }

    public function removeFromCart($cartItemId)
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('login_client')->with('error', 'You need to log in as a client to remove items from the saved.');
        }

        $clientId = Auth::guard('client')->id();

        $cartItem = Cart::where('id', $cartItemId)
                        ->where('client_id', $clientId)
                        ->first();

        if ($cartItem) {
            Cart::destroy($cartItemId);

            $carts = Cart::where('client_id', $clientId)->with('profile')->get();

            return redirect()->route('cartview')->with(['success' => 'Profile removed from Cart.', 'carts' => $carts]);
        }

        return back()->with('error', 'Profile not found in saved.');
    }
}
