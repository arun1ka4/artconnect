<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $search     = request('search');
        $categoryId = request('category');
        $categories = Category::orderBy('name')->get();

        $news = News::with(['category', 'user'])
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest('publish_date')
            ->paginate(9)
            ->withQueryString();

        return view('public.news.index', compact('news', 'categories', 'search', 'categoryId'));
    }

    public function show(string $slug)
    {
        $news = News::with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::with(['category'])
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('publish_date')
            ->take(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}
