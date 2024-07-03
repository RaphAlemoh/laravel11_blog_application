<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //returns all post belonging to the logged in user that is an author
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //returns the page containing the form for creating blog post
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
        ]);

        $user = auth()->user();
        $user->posts()->create($validated);

        return redirect()->route('posts.create')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ulid)
    {
        //display a single post for detialed view
        $post = Post::where('ulid', $ulid)->firstOrFail();
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ulid)
    {
        //return view for the editing of a blog post
        $post = Post::where('ulid', $ulid)->firstOrFail();
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ulid)
    {
        $validated =  $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::where('ulid', $ulid)->firstOrFail();
        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ulid)
    {
        //delete a blog post
        $post = Post::where('ulid', $ulid)->firstOrFail();
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted!!!');
    }

    public function all_posts()
    {
        $posts = Post::latest()->get();
        return view('welcome', compact('posts'));
    }
}
