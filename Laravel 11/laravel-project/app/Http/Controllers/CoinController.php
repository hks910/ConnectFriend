<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoinController extends Controller
{
    public function topup()
    {
        User::where('id', Auth::user()->id)->update([
            'coin' => Auth::user()->coin + 100
        ]);

        return back();
    }
}