<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Exception $e) {}

        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->get();

        $latestProducts = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $settings = SiteSetting::allAsArray();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'settings'));
    }
}
