<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::with(['category', 'user'])
            ->latest('publish_date')
            ->take(6)
            ->get();

        // Take 5 galleries for the featured section
        $latestGalleries = Gallery::withCount('images')
            ->latest()
            ->take(5)
            ->get();

        // All categories for the category section
        $categories = Category::withCount('news')
            ->orderBy('name')
            ->get();

        return view('public.home.index', compact('latestNews', 'latestGalleries', 'categories'));
    }

    public function about()
    {
        return view('public.about.index');
    }
}
