<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Cart;
use App\Models\BankTransferOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

    

class BankTransferController extends Controller
{
    public function showBankTransferForm(Request $request)
    {
        $cartIds = $request->input('cart_ids');
        if (!$cartIds) {
            return redirect()->back()->with('error', 'No profiles selected.');
        }
    
        $totalPrice = 0;
        foreach ($cartIds as $cartId) {
            $cartItem = Cart::with('profile')->find($cartId);
            if ($cartItem) {
                $totalPrice += $cartItem->profile->price;
            }
        }
    
        session(['bank_transfer.cart_ids' => $cartIds, 'bank_transfer.total_price' => $totalPrice]);
    
        return view('client.BankTransfer', compact('totalPrice', 'cartIds'));
    }
    public function submitBankTransfer(Request $request)
    {
        $validatedData = $request->validate([
            'payment_reference' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ]);

        $cartIds = session('bank_transfer.cart_ids');
        $totalPrice = session('bank_transfer.total_price');

        try {
            DB::beginTransaction();
            
            $orderNumber = Str::uuid()->toString();

            $order = new BankTransferOrder([
                'client_id' => auth('client')->id(),
                'total_amount' => $totalPrice,
                'order_number' => $orderNumber, 
                'payment_reference' => $validatedData['payment_reference'],
                'bank_name' => $validatedData['bank_name'],
                'account_number' => $validatedData['account_number'],
                'payment_status' => 'pending', 
            ]);
            $order->save();

            foreach ($cartIds as $cartId) {
                $cart = Cart::findOrFail($cartId);
                $order->profiles()->attach($cart->profile_id);
                $cart->delete(); 
            }

            DB::commit();

            session()->forget(['bank_transfer.cart_ids', 'bank_transfer.total_price']);

            return redirect()->route('client_profiles')->with('success', 'Your Bank transfer is successfully done. The informations of profiles will display after the confirmation of your Bank Transfer !');
        
        } catch (\Exception $e) {
            
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
