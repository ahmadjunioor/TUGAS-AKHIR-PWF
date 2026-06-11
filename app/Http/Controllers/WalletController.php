<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class WalletController extends Controller
{
    public function topup(Request $request)
    {
        $user = Auth::user();
        $amount = 1000000; // Fake top-up amount

        $user->balance += $amount;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'topup',
            'description' => 'Top Up Saldo Dummy',
        ]);

        return back()->with('success', 'Berhasil top up saldo dummy sebesar Rp 1.000.000!');
    }
}
