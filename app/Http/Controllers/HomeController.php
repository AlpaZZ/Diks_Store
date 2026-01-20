<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->available()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::with('category')
            ->available()
            ->latest()
            ->take(12)
            ->get();

        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->where('status', 'available');
            }])
            ->withCount('topups')
            ->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }

    /**
     * Display products by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->available()
            ->latest()
            ->paginate(12);

        $categories = Category::active()->get();

        return view('products.category', compact('category', 'products', 'categories'));
    }

    /**
     * Display all products
     */
    public function products(Request $request)
    {
        $query = Product::with('category')->available();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Sort
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display product detail
     */
    public function productDetail($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $product->incrementViewCount();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->take(4)
            ->get();

        return view('products.detail', compact('product', 'relatedProducts'));
    }

    /**
     * About page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('contact');
    }
}
