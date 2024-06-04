<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'client_id',
        'profile_name',
        'profile_email',
        'profile_phone_number',
        'profile_address',
        'profile_price',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
