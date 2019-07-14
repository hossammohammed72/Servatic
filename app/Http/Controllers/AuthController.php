<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Agent;

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
      if($user['type'] == 'agent')
      Agent::where('user_id',$user['user_id'])->update(['busy'=>0]);
      return $this->respondWithToken($token,$user);
    }

    public function logout(Request $request){
      Agent::where('user_id',$request->user_id)->update(['busy'=>1]);
      return response()->json(['msg'=>'logged out succesfully'],200);
    }

    protected function respondWithToken($token,$type=null)
    {
      
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
         'model'=>$type,
         
      ],200);
    }
}
