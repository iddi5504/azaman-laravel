<?php

namespace App\Http\Controllers;

use App\Enums\NetworkProviders;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

class TransactionController extends Controller
{
    //
    public function index(Request $request)
    {
        $transactions = Transaction::with('wallet')->where('user_id', Auth::user()->id)->get()->toJson();
        dd($transactions);
    }

    public function create(Wallet $wallet)
    {
        return Inertia::render('transaction/StartTransaction', [
            'wallet' => $wallet
        ]);
    }

    public function store(Request $request, Wallet $wallet)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric',],
            'mobile_money_name' => ['required', 'max:100', 'min:4'],
            'mobile_money_number' => ['required', 'min:10', 'max:15'],
            'network_provider' => ['required', new Enum(NetworkProviders::class)]
        ]);


        $wallet->transactions()->create([
            'user_id' => Auth::user()->id,
            'details' => $validated
        ]);

        return redirect()->route('wallets.index')->with(getFlashMessageObject('success', 'Transaction has started', 'Upload Proof of payment'));
    }
}
