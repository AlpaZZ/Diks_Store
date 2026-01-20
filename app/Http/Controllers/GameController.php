<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TopUp;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display list of all games
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount(['products' => function($q) {
                $q->where('status', 'available');
            }])
            ->withCount(['topups' => function($q) {
                $q->where('is_active', true);
            }])
            ->get();

        return view('game.index', compact('categories'));
    }

    /**
     * Display game page with tabs (Top Up & Accounts)
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get top-up packages
        $topups = TopUp::where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('amount')
            ->get();

        // Get currency name from first topup or default
        $currencyName = $this->getCurrencyName($category->slug);

        // Get products (accounts for sale)
        $products = Product::where('category_id', $category->id)
            ->where('status', 'available')
            ->latest()
            ->paginate(9);

        return view('game.show', compact('category', 'topups', 'products', 'currencyName'));
    }

    /**
     * Get currency name based on game
     */
    private function getCurrencyName($slug)
    {
        $currencies = [
            'mobile-legends' => 'Diamonds',
            'free-fire' => 'Diamonds',
            'pubg-mobile' => 'UC',
            'genshin-impact' => 'Genesis Crystals',
            'valorant' => 'VP',
            'clash-of-clans' => 'Gems',
            'honkai-star-rail' => 'Oneiric Shards',
            'arena-of-valor' => 'Vouchers',
        ];

        return $currencies[$slug] ?? 'Currency';
    }
}
