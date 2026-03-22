<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('user')->latest()->get();
        return view('blog.index', compact('posts'));
    }

    public function create() {
        return view('blog.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post) {
        $post->load('comments.user');
        return view('blog.show', compact('post'));
    }
}
