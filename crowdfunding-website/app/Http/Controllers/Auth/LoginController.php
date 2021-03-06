<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email atau password tidak ditemukan'], 401);
        }

        $data['token'] = $token;

        $data['user'] = auth()->user();
        
        if($data['user']->email_verified_at != null){
            return response()->json([
                'response_code' => '00',
                'response_message' => 'user berhasil login',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'message' => 'Email anda belum terverifikasi',
        ]);
    }
}
