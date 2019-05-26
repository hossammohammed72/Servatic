<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);

      $token = auth()->login($user);

      return $this->respondWithToken($token,$user->type());
    }

    public function login(Request $request)
    {
      $credentials = $request->only(['email', 'password']);

      if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
      $user = User::where('email',$request->email)->first();
      $user = (array)$user->type();
      return $this->respondWithToken($token,$user);
    }

    protected function respondWithToken($token,$type=null)
    {
      
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
         'model'=>$type,
         
      ]);
    }
}
