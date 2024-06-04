<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'price',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function isInCart()
    {
       
        return Cart::where('profile_id', $this->id)
                ->where('client_id', Auth::guard('client')->id())
                ->exists();
    }

    public function isPurchasedInCart($clientId)
    {
        return $this->carts()
                    ->where('client_id', $clientId)
                    ->where('ispurchased', true)
                    ->exists();
    }
    public function isPurchased($clientId)
    {
        return $this->purchases()
            ->where('client_id', $clientId)
            ->exists();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'profile_id');
    }

    public function orders()
    {
        return $this->belongsToMany(BankTransferOrder::class, 'order_profile', 'profile_id', 'order_id');
    }

    public function bankTransferOrders()
    {
        return $this->belongsToMany(BankTransferOrder::class, 'order_profile', 'profile_id', 'order_id');
    }

    // public function isInBankTransfer()
    // {
    //     return $this->bankTransferOrders()->whereNotIn('payment_status', ['cancelled'])->exists();
    // }
    public function isPartOfPendingBankTransfer($clientId) {
        return $this->bankTransferOrders()
                    ->where('client_id', $clientId)
                    ->where('payment_status', 'pending')
                    ->exists();
    }

    public function isConfirmedViaBankTransfer($clientId)
    {
        return $this->bankTransferOrders()
                    ->where('client_id', $clientId)
                    ->where('payment_status', 'confirmed')
                    ->exists();
    }
}
