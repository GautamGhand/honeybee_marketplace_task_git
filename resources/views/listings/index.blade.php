@extends('layouts.app')

@section('title', 'Browse Listings - HoneyBee Market')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 16px;">

    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white tracking-tight">
            Explore <span class="text-amber-400">Listings</span>
        </h1>
        <p class="text-sm text-gray-400 mt-1">Find the best deals on products and services near you</p>
    </div>

    {{-- Filter & Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- Sidebar Filters --}}
        <div class="lg:col-span-1">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-xl sticky top-6">
                <form method="GET" action="{{ route('listings.index') }}" class="space-y-6">

                    {{-- Search Input --}}
                    <div>
                        <label for="q" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Search</label>
                        <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="What are you looking for?"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500">
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type Filter (Product / Service) --}}
                    <div>
                        <label for="type" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Type</label>
                        <select name="type" id="type"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                            <option value="">All Types</option>
                            <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Products</option>
                            <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Services</option>
                        </select>
                    </div>

                    {{-- Price Range Filter --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Price Range (₹)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500">
                        </div>
                    </div>

                    {{-- Sorting Filter --}}
                    <div>
                        <label for="sort" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Sort By</label>
                        <select name="sort" id="sort"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-2 pt-2">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3 rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm">
                            Apply Filters
                        </button>
                        <a href="{{ route('listings.index') }}" class="block text-center w-full bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl border border-gray-700 transition-colors text-xs">
                            Reset Filters
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- Listings Results Grid --}}
        <div class="lg:col-span-3">

            @if(isset($listings) && $listings->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($listings as $listing)
                        @php
                            $primaryImg = $listing->images->where('is_primary', true)->first() ?? $listing->images->first();
                        @endphp
                        
                        <a href="{{ route('listings.show', $listing->slug) }}" class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-xl hover:border-amber-500/50 transition-all group flex flex-col justify-between">
                            <div>
                                {{-- Thumbnail --}}
                                <div class="h-48 w-full bg-gray-950 relative overflow-hidden flex items-center justify-center">
                                    @if($primaryImg)
                                        <img src="{{ asset('storage/' . $primaryImg->image_path) }}" alt="{{ $listing->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="text-gray-700">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif

                                    {{-- Price Badge --}}
                                    <span class="absolute top-3 right-3 bg-gray-950/80 backdrop-blur-md text-amber-400 font-extrabold px-3 py-1 rounded-xl text-xs border border-gray-800 shadow-md">
                                        ₹{{ number_format($listing->price) }}
                                    </span>

                                    {{-- Type Tag --}}
                                    <span class="absolute bottom-3 left-3 bg-amber-500/90 text-gray-950 font-bold px-2.5 py-0.5 rounded-lg text-[10px] uppercase tracking-wider">
                                        {{ $listing->type ?? 'Ad' }}
                                    </span>
                                </div>

                                {{-- Details --}}
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-100 truncate mb-1 group-hover:text-amber-400 transition-colors">
                                        {{ $listing->title }}
                                    </h3>
                                    <p class="text-xs text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                                        {{ $listing->description }}
                                    </p>
                                </div>
                            </div>

                            {{-- Footer Meta --}}
                            <div class="px-5 py-3 bg-gray-950/40 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-400">
                                <span class="truncate max-w-[120px]">
                                    📍 {{ $listing->city->name ?? $listing->location ?? 'N/A' }}
                                </span>
                                <span>
                                    {{ $listing->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="mt-8">
                    {{ $listings->links() }}
                </div>

            @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-gray-900 border border-gray-800 rounded-3xl">
                    <svg class="w-16 h-16 mx-auto text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <h3 class="text-lg font-semibold text-gray-300 mb-1">No listings found</h3>
                    <p class="text-sm text-gray-500 mb-6">Try adjusting your filter search criteria.</p>
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold px-5 py-2.5 rounded-xl transition-all text-sm">
                        Clear Filters
                    </a>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection