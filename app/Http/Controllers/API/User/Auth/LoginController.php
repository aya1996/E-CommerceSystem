<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->get('remember'))) 
        {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ], 200);
        } 
      
        return response()->json(['error' => 'Unauthenticated'], 401);
      




    }
}
