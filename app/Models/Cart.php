<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = ['client_id', 'profile_id', 'quantity', 'ispurchased']; 


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
    
}
