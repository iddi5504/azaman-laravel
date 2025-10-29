<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function transactionProofs(): HasMany
    {
        return $this->hasMany(TransactionProof::class);
    }

    public function scopeFilter($q, Request $request)
    {
        $q->where(function ($q) use ($request) {
            if ($request->user()->isAdmin()) {
                return $q;
            } else {
                return $q->where('user_id', Auth::user()->id);
            }
        });

        if ($request->query('transaction_status')) {
            $q->where('status', $request->query('transaction_status'));
        }

        if ($request->query('wallet')) {
            $q->where('wallet_id', $request->wallet);
        }
    }
}
