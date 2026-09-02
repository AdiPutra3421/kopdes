<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all(); // Mengambil semua data dari tabel posts
        return view('posts.index', compact('posts')); // Mengirim data ke View
    }
}