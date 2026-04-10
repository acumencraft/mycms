<?php

namespace App\Http\Controllers;

use App\Models\PortfolioProject;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = PortfolioProject::with('images')->orderBy('completed_at', 'desc')->get();
        $page = \App\Models\Page::where('slug', 'portfolio')->first();

        return view('portfolio', compact('projects', 'page'));
    }

    public function show($id)
    {
        $project = PortfolioProject::with('images')->findOrFail($id);
        return view('portfolio.show', compact('project'));
    }
}