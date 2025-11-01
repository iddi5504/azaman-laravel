<?php

namespace App\Http\Controllers;

use App\Enums\NetworkProviders;
use App\Enums\TransactionStatus;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;


class TransactionController extends Controller
{
    //

    public function middleware()
    {
        return [
            new Middleware(AdminMiddleware::class, only: ['approveTransaction'])
        ];
    }

    public function index(Request $request)
    {
        $transactions = Transaction::with('wallet')->filter($request)->get();

        $query = $request->query();

        $wallets = Wallet::select('id', 'name')->get()->map(fn($d) => [
            'label' => $d->name,
            'value' => $d->id
        ]);

        return Inertia::render('transaction/Index', compact('transactions', 'query', 'wallets'));
    }


    public function show(Request $request, Transaction $transaction)
    {
        $transaction->load(['wallet', 'transactionProofs']);
        return Inertia::render('transaction/TransactionShow', compact('transaction'));
    }

    public function create(Wallet $wallet)
    {
        return Inertia::render('transaction/StartTransaction', [
            'wallet' => $wallet
        ]);
    }

    /**
     * Approve a transaction by changing the status to completed
     * @param Transaction $transaction The id of the transaction
     */
    public function approveTransaction(Transaction $transaction)
    {
        $transaction->status = TransactionStatus::COMPELETED->value;
        $transaction->save();
        return redirect()->route('transaction.show', $transaction->id)->with(getFlashMessageObject('success', 'Transaction has been completed and approved',));
    }


    /**
     * Reject a transaction by changing the status to failed
     * @param Transaction $transaction The id of the transaction
     */
    public function rejectTransaction(Transaction $transaction)
    {
        $transaction->status = TransactionStatus::FAILED->value;
        $transaction->save();
        return redirect()->route('transaction.show', $transaction->id)->with(getFlashMessageObject('warning', 'You have rejected this transaction',));
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

        return redirect()->route('transaction.index')->with(getFlashMessageObject('success', 'Transaction has started', 'Upload Proof of payment'));
    }
}
