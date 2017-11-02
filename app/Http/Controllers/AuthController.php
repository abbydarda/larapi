<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transformer\UserTransformer;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request, User $user)
    {
      $this->validate($request, [
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6'
      ]);

      $users = $user->Create([
        'name'=>$request->name,
        'email'=>$request->email,
        'api_token'=>bcrypt($request->email),
        'password'=> bcrypt($request->password)
      ]);

      $response = fractal()
              ->item($users)
              ->transformWith(new UserTransformer)
              ->addMeta([
                'token'=>$users->api_token
              ])
              ->toArray();
      return response()->json($response, 201);
    }

    public function login(Request $request, User $user)
    {
      if (!Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
        return response()->json(['error'=>'your credential is wrong'],401);
      }

      $users = $user->find(Auth::user()->id);

      return $response = fractal()
              ->item($users)
              ->transformWith(new UserTransformer)
              ->addMeta([
                'token'=>$users->api_token
              ])
              ->toArray();

    }
}
