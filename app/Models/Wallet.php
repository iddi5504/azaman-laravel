<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Wallet extends Model
{
    //
    protected $fillable = [
        'name',
        'icon',
        'account_type',
        'owner_name',
        'tag',
        'countries',
        'gender'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeFilter($q, array $fields)
    {
        if ($fields['search'] ?? false) {
            $q->where(function ($q) {
                $q->where('name', 'ilike', '%' . request('search') . '%')->orWhere('owner_name', 'ilike',  '%' . request('search') . '%');
            });
        }

        if ($fields['account_type'] ?? false) {
            $q->where('account_type', $fields['account_type']);
        }
    }
}
