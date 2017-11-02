<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transformer\UserTransformer;
use Auth;

class UserController extends Controller
{
    public function users(User $user)
    {
      $users = $user->all();
      return fractal()
              ->collection($users)
              ->transformWith(new UserTransformer)
              ->toArray();
    }

    public function profile(User $user)
    {
      $users = $user->find(Auth::user()->id);
      return fractal()
              ->item($users)
              ->transformWith(new UserTransformer)
              ->includePosts()
              ->toArray();
    }
}
