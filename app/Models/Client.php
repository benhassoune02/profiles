<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'clients';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function bankTransferOrders()
    {
        return $this->hasMany(BankTransferOrder::class);
    }
}

