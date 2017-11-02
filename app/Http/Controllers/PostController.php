<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Transformer\PostTransformer;
use Auth;

class PostController extends Controller
{
    public function add(Request $request, Post $post)
    {
      $this->validate($request, [
        'content'=>'required',
      ]);

      $posts = $post->create([
        'user_id' => Auth::user()->id,
        'content' => $request->content,
      ]);

      $response = fractal()
                  ->item($posts)
                  ->transformWith(new PostTransformer)
                  ->toArray();

      return response()->json($response, 201);
    }

    public function list(Post $post)
    {
      $post = $user->find(Auth::User()->id);
       $response = fractal()
                  ->item($post)
                  ->transformWith(new PostTransformer)
                  ->toArray();

        return response()->json($response);
    }
}
