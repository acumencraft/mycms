<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', true)->get();
        $page = \App\Models\Page::where('slug', 'services')->first();

        return view('services', compact('services', 'page'));
    }
}