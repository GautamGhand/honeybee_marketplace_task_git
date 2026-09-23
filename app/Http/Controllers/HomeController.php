<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;

class HomeController extends Controller
{
    /**
     * Show the marketplace homepage.
     */
    public function index()
    {
        $categories = Category::topLevel()->with('children')->get();

        $latestListings = Listing::active()
            ->with(['category', 'city', 'images'])
            ->latest()
            ->take(12)
            ->get();

        $featuredCities = Location::cities()
            ->withCount(['children as listings_count' => function ($query) {
                // This won't work as-is, we'll count differently
            }])
            ->take(8)
            ->get();

        // Get popular cities based on listing count
        $popularCities = Location::where('type', 'city')
            ->whereHas('children', function ($query) {
                // cities that have listings
            })
            ->orWhereIn('id', Listing::active()->pluck('city_id')->unique())
            ->take(8)
            ->get();

        return view('home', compact('categories', 'latestListings', 'popularCities'));
    }
}
