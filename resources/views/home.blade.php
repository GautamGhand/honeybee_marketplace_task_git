@extends('layouts.app')

@section('title', 'HoneyBee Market - Buy & Sell Anything Near You')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden">
    {{-- Background gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 via-gray-950 to-gray-950"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                Buy & Sell
                <span class="bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 bg-clip-text text-transparent">Anything</span>
                <br>Near You
            </h1>
            <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto">
                India's most trusted marketplace. Find the best deals on electronics, vehicles, property, and more in your city.
            </p>

            {{-- Search Box --}}
            <form action="{{ route('listings.index') }}" method="GET" class="max-w-2xl mx-auto" id="hero-search-form">
                <div class="flex flex-col sm:flex-row gap-3 bg-gray-900/80 backdrop-blur-xl border border-gray-800/50 rounded-2xl p-3 shadow-2xl shadow-black/20">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" placeholder="What are you looking for?" class="w-full bg-gray-800/50 rounded-xl pl-11 pr-4 py-3 text-gray-200 placeholder-gray-500 border-0 focus:outline-none focus:ring-2 focus:ring-amber-500/30 text-sm" id="hero-search-input">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-900 font-semibold px-8 py-3 rounded-xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all active:scale-95 text-sm" id="hero-search-btn">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-100">Browse Categories</h2>
            <p class="text-sm text-gray-500 mt-1">Find what you need in the right category</p>
        </div>
        <a href="{{ route('listings.index') }}" class="text-sm text-amber-400 hover:text-amber-300 font-medium transition-colors">
            View All →
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('listings.category', $cat->slug) }}"
           class="group relative bg-gray-900/50 border border-gray-800/50 rounded-2xl p-6 text-center hover:border-amber-500/30 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden"
           id="category-{{ $cat->slug }}">
            {{-- Glow effect --}}
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/0 to-amber-500/0 group-hover:from-amber-500/5 group-hover:to-amber-500/10 transition-all duration-500"></div>

            <div class="relative">
                {{-- Icon --}}
                <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-amber-400/10 to-amber-600/10 border border-amber-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:border-amber-500/40 transition-all duration-300">
                    @switch($cat->icon)
                        @case('device-mobile')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            @break
                        @case('car')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10m10 0h-4m0 0H5m8 0h2m0 0h3a2 2 0 002-2v-3a2 2 0 00-2-2h-1l-2.5-4H13"/></svg>
                            @break
                        @case('building')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            @break
                        @case('shirt')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            @break
                        @case('briefcase')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @break
                        @case('wrench')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @break
                        @case('armchair')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            @break
                        @case('paw')
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @break
                        @default
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    @endswitch
                </div>

                <h3 class="text-sm font-semibold text-gray-300 group-hover:text-amber-400 transition-colors">{{ $cat->name }}</h3>
                <p class="text-xs text-gray-600 mt-1">{{ $cat->children->count() }} subcategories</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- Fresh Listings Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-100">Fresh Listings</h2>
            <p class="text-sm text-gray-500 mt-1">Recently posted ads near you</p>
        </div>
        <a href="{{ route('listings.index') }}" class="text-sm text-amber-400 hover:text-amber-300 font-medium transition-colors">
            View All →
        </a>
    </div>

    @if($latestListings->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($latestListings as $listing)
            @include('components.listing-card', ['listing' => $listing])
        @endforeach
    </div>
    @else
    <div class="text-center py-20 bg-gray-900/30 rounded-2xl border border-gray-800/30">
        <svg class="w-16 h-16 mx-auto text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <h3 class="text-lg font-medium text-gray-400 mb-2">No listings yet</h3>
        <p class="text-sm text-gray-600 mb-6">Be the first to post an ad!</p>
        <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-900 font-semibold px-6 py-2.5 rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Post Your First Ad
        </a>
    </div>
    @endif
</section>

{{-- CTA Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-500/10 to-amber-600/5 border border-amber-500/20 rounded-3xl p-10 md:p-16 text-center">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Ready to <span class="text-amber-400">sell</span> something?
            </h2>
            <p class="text-gray-400 mb-8 max-w-lg mx-auto">
                Post your ad for free and reach thousands of buyers in your city. It only takes a minute!
            </p>
            <a href="{{ route('listings.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-900 font-bold px-8 py-3.5 rounded-xl shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 transition-all active:scale-95 text-base"
               id="cta-post-ad">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post Your Ad — It's Free
            </a>
        </div>
    </div>
</section>
@endsection
