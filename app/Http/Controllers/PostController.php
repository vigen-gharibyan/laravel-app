<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response($posts->jsonSerialize(), Response::HTTP_OK);
    }

    public function show($id)
    {
        $post = Post::find($id);

        return response($post->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $post = new Post([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);
        $post->save();

        return response($post->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $post->title = $request->get('title');
        $post->content = $request->get('content');
        $post->save();

        return response($post->jsonSerialize(), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Item::destroy($id);

        return response(null, Response::HTTP_OK);
    }

}
