<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
                'show',
            ]
        ]);
    }

    public function index()
    {
        $posts = Post::all();

        return response()->json($posts, Response::HTTP_OK);
    }

    public function show($id)
    {
        $post = Post::find($id);

        return response()->json($post, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $post = new Post([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);
        $post->save();

        return response()->json($post, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->title = $request->get('title');
            $post->content = $request->get('content');
            $post->save();
        }

        return response()->json($post, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Post::destroy($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

}
