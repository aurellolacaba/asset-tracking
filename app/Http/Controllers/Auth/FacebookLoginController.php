<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function handleFacebookCallback(){
        $facebook_user = Socialite::driver('facebook')->stateless()->user();
        
        $user = User::updateOrCreate([
            'facebook_id' => $facebook_user->id,
        ], [
            'name' => $facebook_user->name,
            'email' => $facebook_user->email
        ]);
     
        $access_token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'message' => 'success',
            'access_token' => $access_token
        ]);
    }
}
