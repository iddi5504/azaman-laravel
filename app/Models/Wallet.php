<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeFilter($q, array $fields)
    {
        if ($fields['search'] ?? false) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')->orWhere('owner_name', 'like',  '%' . request('search') . '%');
            });
        }

        if ($fields['account_type'] ?? false) {
            $q->where('account_type', $fields['account_type']);
        }
    }
}
