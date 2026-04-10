<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::with('author')
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $page = \App\Models\Page::where('slug', 'blog')->first();

        return view('blog', compact('publications', 'page'));
    }

    public function show($slug)
    {
        $publication = Publication::with('author', 'categories', 'tags')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return view('blog.show', compact('publication'));
    }
}