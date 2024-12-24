<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::all());
    }

    public function show($id)
    {
        return response()->json(Post::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string',
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'author' => 'sometimes|string',
        ]);

        $post->update($validated);
        return response()->json($post);
    }
}
