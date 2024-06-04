<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransferOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'total_amount', 
        'client_id',
        'payment_reference',
        'bank_name',
        'account_number',
        'payment_status',
    ];

    protected $dates = ['confirmed_at', 'deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'order_profile', 'order_id', 'profile_id');
    }

    public function confirmPayment()
    {
        $this->update([
            'payment_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

    }

    public function getTotalAmountAttribute()
    {
        return $this->profiles->sum('price');
    }


    public function getFormattedTotalAmountAttribute()
    {
        return "$" . number_format($this->total_amount, 2);
    }

}
