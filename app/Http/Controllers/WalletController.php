<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;
use App\Models\Wallet;
use App\Traits\MyStorage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class WalletController extends Controller implements HasMiddleware
{

    use MyStorage;

    function __construct()
    {
        $this->initStorage();
    }

    public static function middleware()
    {
        return [
            new Middleware(AdminMiddleware::class, except: ['index'])
        ];
    }
    //

    public function index(Request $request)
    {
        $wallets =  Wallet::all();
        return Inertia::render('Wallets', [
            'wallets' => $wallets
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('admin/AddWallet');
    }


    public function edit(Request $request, Wallet $wallet)
    {
        return Inertia::render('admin/AddWallet', [
            'editMode' => true,
            'wallet' => $wallet
        ]);
    }

    public function update(Request $request, Wallet $wallet)
    {
        $validated = $this->validateFields($request);

        $wallet->update($validated);

        return redirect()->route('wallets.index')->with(getFlashMessageObject('success', 'Wallet has been updated'));
    }

    function validateFields(Request $request)
    {
        $validated = $request->validate([
            'gender' => ['required'],
            'name' => ['sometimes', 'max:150'],
            'owner_name' => ['required', 'max:100'],
            'tag' => ['required'],
            'account_type' => ['required'],
            'country' => ['required'],
        ]);

        return $validated;
    }

    public function store(Request $request)
    {
        $validated = $this->validateFields($request);

        if ($request->hasFile('icon')) {
            $path = $this->upload($request->file('icon'), 'wallet-icons');
            $validated['icon'] = $path;
        }

        Wallet::create($validated);

        return redirect()->route('wallets.index')->with(getFlashMessageObject('success', 'New wallet has been added'));
    }

    public function destroy(Request $request, Wallet $wallet)
    {
        $wallet->delete();
        return redirect()->route('wallets.index')->with(getFlashMessageObject('success', 'Wallet has been deleted'));
    }
}
