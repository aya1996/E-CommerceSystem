<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
            // admin guard to login
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) 
        {


            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'admin' => $admin
            ], 200);
           
        } 
      
            return response()->json(['error' => 'Unauthenticated'], 401);
           
      

    
    }

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed',

        ]);
        $user = Admin::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'password'  => Hash::make($attr['password']),
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;
        $response = [
            'admin'     => $user->only(['name', 'email']),
            'token'    => $token
        ];
        return response($response, 201);


        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        // $success['name'] =  $user->name;

        // return $this->handleResponse($success, 'User successfully registered!');
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }

}
