<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Cart;


class PurchasedProfilesController extends Controller
{
    public function index()
    {
        $purchasedProfiles = Purchase::with('profile')->get();

        $cartProfiles = Cart::where('ispurchased', true)->with('profile')->get();

        return view('admin.purchased_profile', compact('purchasedProfiles', 'cartProfiles'));
    }

    public function deleteCartPurchasedProfile($id)
    {
        $cartItem = Cart::find($id);
    
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Profile not found.');
        }
    
        $cartItem->delete();
    
        return redirect()->back()->with('success', 'Profile deleted successfully.');
    }
}
