<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{


    //
    protected $fillable = [
        'details',
        'user_id',
        'wallet_id'
    ];

    protected $casts = [
        'details' => 'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
