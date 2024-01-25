<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
   use HttpResponses;

   public function login(LoginUserRequest $request) {
    $request->validated($request->all());

    // check if the user exist 
    if(!Auth::attempt($request->only(['email', 'password']))) {
        return $this->error('', 'Credentials do not match', 401);
    }

     // Check email
    $user = User::where('email', $request->email)->first();

    return $this->success([
        'user' => $user,
        'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
    ]);
   }

   public function register(StoreUserRequest $request) {

    $request->validated($request->all());

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    return $this->success([
        'user' => $user,
        'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken,
        'role' => $user->role,
        'message' => 'Registration success',
    ]);
   }

   
   public function logout() {
    Auth::user()->currentAccessToken()->delete();

    return $this->success([
        'message' => 'logged out successfully'
    ]);
   }
}

