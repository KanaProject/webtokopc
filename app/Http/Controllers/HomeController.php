<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Testimonial;
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

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();

        $settings = SiteSetting::allAsArray();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'settings', 'testimonials'));
    }

    public function submitTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_or_location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'role_or_location' => $validated['role_or_location'],
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'is_active' => false, // Default to inactive pending admin approval
        ]);

        return redirect()->route('home')->with('success', 'Terima kasih! Ulasan Anda telah terkirim dan sedang menunggu persetujuan admin.');
    }
}
