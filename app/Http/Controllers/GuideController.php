<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $guides = Guide::with('category')->orderBy('created_at', 'desc')->paginate(12);
        $page = \App\Models\Page::where('slug', 'guides')->first();
        return view('guides', compact('guides', 'page'));
    }

    public function show($slug)
    {
        $guide = Guide::with('category')->where('slug', $slug)->firstOrFail();
        return view('guides.show', compact('guide'));
    }
}