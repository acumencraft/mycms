<?php
namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Service;
use App\Models\PortfolioProject;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\Feature;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Cache::remember('home.services', 3600, function () {
            return Service::where('status', true)->take(6)->get();
        });

        $featuredProjects = Cache::remember('home.projects', 3600, function () {
            return PortfolioProject::with('images')->where('is_featured', true)->take(6)->get();
        });

        $latestPublications = Cache::remember('home.publications', 1800, function () {
            return Publication::with('author')
                ->where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        });

        $testimonials = Cache::remember('home.testimonials', 3600, function () {
            return Testimonial::where('is_featured', true)->take(3)->get();
        });

        $features = Cache::remember('home.features', 3600, function () {
            return Feature::all();
        });

        $homePage = Cache::remember('home.page', 3600, function () {
            return Page::where('slug', 'home')->first();
        });

        return view('home', compact(
            'featuredServices',
            'featuredProjects',
            'latestPublications',
            'testimonials',
            'homePage',
            'features'
        ));
    }
}
