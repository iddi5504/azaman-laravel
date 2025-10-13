<?php

namespace App\Models;

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
}
