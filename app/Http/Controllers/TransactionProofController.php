<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use App\Traits\MyStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionProofController extends Controller
{
    //
    use MyStorage;

    function __construct()
    {
        $this->initStorage();
    }

    public function store(Request $request, Transaction $transaction)
    {
        $request->validate(
            [
                'image' => ['required', 'image']
            ]
        );

        $file = $request->file('image');

        DB::transaction(function () use ($file,  $transaction) {
            $path = $this->upload($file, 'transaction-proofs');

            $transaction->transactionProofs()->create([
                'file_path' => $path,
                'user_id' => Auth::user()->id
            ]);

            $transaction->status = TransactionStatus::PROCESSING->value;

            $transaction->save();
        });

        return redirect()->route('transaction.show', $transaction->id)->with(getFlashMessageObject('success', 'Proof of payment has been made', 'Transaction is being processed'));
    }
}
