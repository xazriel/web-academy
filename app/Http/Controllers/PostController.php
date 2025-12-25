<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug)
    {
        // Cari postingan berdasarkan slug
        $post = Post::where('slug', $slug)->firstOrFail();
        
        return view('posts.show', compact('post'));
    }
}