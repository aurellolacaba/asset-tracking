<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $revoke_token = auth()->user()->currentAccessToken()->delete();

        if (!$revoke_token) {
            return response()->json([
                'message' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }
}
