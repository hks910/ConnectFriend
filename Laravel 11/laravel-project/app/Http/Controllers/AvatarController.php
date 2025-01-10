<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\AvatarTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function buyAvatar($avatar_id)
    {
        $avatar = Avatar::findOrFail($avatar_id);
        
        AvatarTransaction::create([
            'buyer_id' => Auth::user()->id,
            'avatar_id' => $avatar_id
        ]);

        User::findOrFail(Auth::user()->id)->update([
            'coin' => Auth::user()->coin - $avatar->price
        ]);

        return back();
    }
}