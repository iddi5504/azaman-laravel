<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
