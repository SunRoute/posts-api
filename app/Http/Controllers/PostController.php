<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);
        return response()->json($post);
    }
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $post->update([
            'title' => $request->title ?? $post->title,
            'content' => $request->content ?? $post->content,
        ]);

        return response()->json($post);
    }
}
