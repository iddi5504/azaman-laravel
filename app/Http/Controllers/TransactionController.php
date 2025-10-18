<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    //
    public function index(Request $request, Wallet $wallet)
    {
        return Inertia::render('transaction/StartTransaction', [
            'wallet' => $wallet
        ]);
    }
}
