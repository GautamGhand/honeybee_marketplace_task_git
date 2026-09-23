<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    /**
     * Browse all listings with filters.
     */
    public function index(Request $request)
    {
        $query = Listing::active()->with(['category', 'subcategory', 'city', 'state', 'images', 'user']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by subcategory
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Filter by location
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
       if ($request->filled('q')) {
            $searchTerm = strtolower($request->q);
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        $query = match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $listings = $query->paginate(12)->withQueryString();
        $categories = Category::topLevel()->with('children')->get();
        $countries = Location::countries()->get();

        return view('listings.index', compact('listings', 'categories', 'countries'));
    }

    /**
     * Show a single listing.
     */
    public function show(string $slug)
    {
        $listing = Listing::where('slug', $slug)
            ->with(['category', 'subcategory', 'country', 'state', 'city', 'area', 'images', 'user'])
            ->firstOrFail();

        // Increment views
        $listing->increment('views_count');

        // Get similar listings
        $similarListings = Listing::active()
            ->where('id', '!=', $listing->id)
            ->where('category_id', $listing->category_id)
            ->with(['city', 'images'])
            ->latest()
            ->take(4)
            ->get();

        return view('listings.show', compact('listing', 'similarListings'));
    }

    /**
     * Show the post ad form.
     */
    public function create()
    {
        // Parent categories with subcategories
        $categories = Category::whereNull('parent_id')->get();
        $subcategories = Category::whereNotNull('parent_id')->get();

        // Locations hierarchy
        $countries = Location::whereNull('parent_id')->get();
        $states = Location::whereIn('parent_id', $countries->pluck('id'))->get();
        $cities = Location::whereIn('parent_id', $states->pluck('id'))->get();
        $areas = Location::whereIn('parent_id', $cities->pluck('id'))->get();

        return view('listings.create', compact(
            'categories', 
            'subcategories', 
            'countries', 
            'states', 
            'cities', 
            'areas'
        ));
    }

    public function edit($id)
    {
        $listing = Listing::findOrFail($id);

        $categories = Category::whereNull('parent_id')->get();
        $subcategories = Category::whereNotNull('parent_id')->get();

        $countries = Location::whereNull('parent_id')->get();
        $states = Location::whereIn('parent_id', $countries->pluck('id'))->get();
        $cities = Location::whereIn('parent_id', $states->pluck('id'))->get();
        $areas = Location::whereIn('parent_id', $cities->pluck('id'))->get();

        return view('listings.edit', compact(
            'listing', 
            'categories', 
            'subcategories', 
            'countries', 
            'states', 
            'cities', 
            'areas'
        ));
    }

    /**
     * Store a new listing.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:product,service'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:categories,id'],
            'country_id' => ['required', 'exists:locations,id'],
            'state_id' => ['required', 'exists:locations,id'],
            'city_id' => ['required', 'exists:locations,id'],
            'area_id' => ['nullable', 'exists:locations,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $listing = Listing::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'area_id' => $validated['area_id'] ?? null,
            'price' => $validated['price'],
            'currency' => 'INR',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings/' . $listing->id, 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('listings.show', $listing->slug)
            ->with('success', 'Your ad has been posted successfully!');
    }

    public function update(Request $request, Listing $listing)
    {
        // Authorization check
        if ($listing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'type' => ['sometimes', 'required', 'in:product,service'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:categories,id'],
            'country_id' => ['sometimes', 'nullable', 'exists:locations,id'],
            'state_id' => ['sometimes', 'nullable', 'exists:locations,id'],
            'city_id' => ['sometimes', 'nullable', 'exists:locations,id'],
            'area_id' => ['sometimes', 'nullable', 'exists:locations,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        // Update listing data
        $listing->update([
            'type' => $validated['type'] ?? $listing->type,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? $listing->subcategory_id,
            'country_id' => $validated['country_id'] ?? $listing->country_id,
            'state_id' => $validated['state_id'] ?? $listing->state_id,
            'city_id' => $validated['city_id'] ?? $listing->city_id,
            'area_id' => $validated['area_id'] ?? $listing->area_id,
            'price' => $validated['price'],
        ]);

        // Handle new images upload if provided
        if ($request->hasFile('images')) {
            $existingCount = $listing->images()->count();

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings/' . $listing->id, 'public');
                
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'is_primary' => ($existingCount === 0 && $index === 0),
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('listings.my-listings')
            ->with('success', 'Listing updated successfully!');
    }

    /**
     * Show listings by category.
     */
    public function byCategory(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $query = Listing::active()
            ->with(['category', 'subcategory', 'city', 'state', 'images', 'user']);

        // If it's a parent category, include all subcategory listings too
        if ($category->isParent()) {
            $subcategoryIds = $category->children->pluck('id');
            $query->where(function ($q) use ($category, $subcategoryIds) {
                $q->where('category_id', $category->id)
                  ->orWhereIn('subcategory_id', $subcategoryIds);
            });
        } else {
            $query->where('subcategory_id', $category->id);
        }

        $listings = $query->latest()->paginate(12);
        $categories = Category::topLevel()->with('children')->get();
        $countries = Location::countries()->get();

        return view('listings.index', compact('listings', 'categories', 'countries', 'category'));
    }

    /**
     * Show listings by city.
     */
    public function byCity(string $citySlug)
    {
        $city = Location::where('slug', $citySlug)->where('type', 'city')->firstOrFail();

        $listings = Listing::active()
            ->where('city_id', $city->id)
            ->with(['category', 'subcategory', 'city', 'state', 'images', 'user'])
            ->latest()
            ->paginate(12);

        $categories = Category::topLevel()->with('children')->get();
        $countries = Location::countries()->get();

        return view('listings.index', compact('listings', 'categories', 'countries', 'city'));
    }

    /**
     * Show listings by city and category.
     */
    public function byCityAndCategory(string $citySlug, string $categorySlug)
    {
        $city = Location::where('slug', $citySlug)->where('type', 'city')->firstOrFail();
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $query = Listing::active()
            ->where('city_id', $city->id)
            ->with(['category', 'subcategory', 'city', 'state', 'images', 'user']);

        if ($category->isParent()) {
            $subcategoryIds = $category->children->pluck('id');
            $query->where(function ($q) use ($category, $subcategoryIds) {
                $q->where('category_id', $category->id)
                  ->orWhereIn('subcategory_id', $subcategoryIds);
            });
        } else {
            $query->where('subcategory_id', $category->id);
        }

        $listings = $query->latest()->paginate(12);
        $categories = Category::topLevel()->with('children')->get();
        $countries = Location::countries()->get();

        return view('listings.index', compact('listings', 'categories', 'countries', 'city', 'category'));
    }

    /**
     * Show current user's listings.
     */
    public function myListings()
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with(['category', 'city', 'images'])
            ->latest()
            ->paginate(12);

        return view('listings.my-listings', compact('listings'));
    }
}
