@extends('layouts.app')

@section('title', $listing->title . ' - HoneyBee Market')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 16px;">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex text-xs text-gray-400 mb-6 gap-2 items-center flex-wrap">
        <a href="{{ route('listings.index') }}" class="hover:text-amber-400 transition-colors">Home</a>
        <span>/</span>
        @if($listing->category)
            <a href="{{ route('listings.byCategory', $listing->category->slug) }}" class="hover:text-amber-400 transition-colors">
                {{ $listing->category->name }}
            </a>
            <span>/</span>
        @endif
        <span class="text-gray-200 font-medium truncate max-w-xs">{{ $listing->title }}</span>
    </nav>

    {{-- Main Grid Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Images & Details (2 Cols) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Image Gallery --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-4 shadow-2xl">
                @php
                    $primaryImage = $listing->images->where('is_primary', true)->first() ?? $listing->images->first();
                @endphp

                {{-- Main Image Box --}}
                <div class="relative w-full h-[380px] sm:h-[480px] bg-gray-950 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-800">
                    @if($primaryImage)
                        <img id="mainDisplayImage" src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $listing->title }}" class="w-full h-full object-contain">
                    @else
                        <div class="text-center text-gray-600">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs">No Image Available</p>
                        </div>
                    @endif

                    <span class="absolute top-4 left-4 bg-amber-500 text-gray-950 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg">
                        {{ $listing->type ?? 'Product' }}
                    </span>
                </div>

                {{-- Thumbnails --}}
                @if($listing->images->count() > 1)
                    <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2 scrollbar-thin">
                        @foreach($listing->images as $img)
                            <button type="button" onclick="document.getElementById('mainDisplayImage').src = '{{ asset('storage/' . $img->image_path) }}'" 
                                class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden border-2 border-gray-800 hover:border-amber-500 focus:border-amber-500 transition-all bg-gray-950">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Description & Overview --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-white mb-3">Description</h3>
                    <p class="text-gray-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                        {{ $listing->description }}
                    </p>
                </div>

                <hr class="border-gray-800">

                {{-- Quick Meta Features --}}
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Ad Details</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-800/50 p-3.5 rounded-2xl border border-gray-800">
                            <p class="text-[11px] text-gray-400">Category</p>
                            <p class="text-sm font-semibold text-white truncate">{{ $listing->category->name ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-800/50 p-3.5 rounded-2xl border border-gray-800">
                            <p class="text-[11px] text-gray-400">Location</p>
                            <p class="text-sm font-semibold text-white truncate">
                                {{ $listing->city->name ?? $listing->location ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-gray-800/50 p-3.5 rounded-2xl border border-gray-800">
                            <p class="text-[11px] text-gray-400">Posted Date</p>
                            <p class="text-sm font-semibold text-white truncate">{{ $listing->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-gray-800/50 p-3.5 rounded-2xl border border-gray-800">
                            <p class="text-[11px] text-gray-400">Views</p>
                            <p class="text-sm font-semibold text-white truncate">{{ number_format($listing->views_count ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column: Price & Seller Details (1 Col) --}}
        <div class="space-y-6">
            
            {{-- Price Card --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl">
                <h1 class="text-2xl font-extrabold text-white mb-2 leading-snug">{{ $listing->title }}</h1>
                <div class="flex items-baseline gap-2 my-4">
                    <span class="text-3xl font-black text-amber-400">
                        ₹{{ number_format($listing->price) }}
                    </span>
                    <span class="text-xs text-gray-400">INR</span>
                </div>

                {{-- Action Buttons --}}
                @if(Auth::check() && Auth::id() === $listing->user_id)
                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ route('listings.edit', $listing->id) }}" class="flex-1 text-center bg-gray-800 hover:bg-gray-700 text-amber-400 border border-amber-500/30 font-bold py-3 px-4 rounded-xl transition-all text-sm">
                            Edit Listing
                        </a>
                    </div>
                @else
                    <a href="tel:{{ $listing->user->phone ?? '' }}" class="w-full block text-center bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm mb-3">
                        Contact Seller
                    </a>
                @endif
            </div>

            {{-- Seller Profile Card --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl space-y-4">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Seller Information</h3>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 font-bold text-lg">
                        {{ strtoupper(substr($listing->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-white">{{ $listing->user->name ?? 'Anonymous User' }}</h4>
                        <p class="text-xs text-gray-400">Member since {{ optional($listing->user->created_at)->format('M Y') ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="pt-2">
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $listing->city->name ?? 'Location Not Specified' }}, {{ $listing->state->name ?? '' }}</span>
                    </div>
                </div>
            </div>

            {{-- Safety Tips Card --}}
            <div class="bg-gray-900/60 border border-gray-800/80 rounded-3xl p-5 text-xs text-gray-400 space-y-2">
                <h4 class="font-bold text-amber-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Safety Tips
                </h4>
                <ul class="list-disc list-inside space-y-1 text-gray-400 pl-1">
                    <li>Meet seller in a public place.</li>
                    <li>Inspect product before paying.</li>
                    <li>Avoid advance payment transfers.</li>
                </ul>
            </div>

        </div>

    </div>

    {{-- Similar Listings Section --}}
    @if(isset($similarListings) && $similarListings->count() > 0)
        <div class="mt-16">
            <h3 class="text-2xl font-extrabold text-white mb-6">Similar <span class="text-amber-400">Listings</span></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($similarListings as $similar)
                    @php
                        $simImg = $similar->images->first();
                    @endphp
                    <a href="{{ route('listings.show', $similar->slug) }}" class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden shadow-lg hover:border-amber-500/50 transition-all flex flex-col justify-between group">
                        <div class="h-40 bg-gray-950 relative overflow-hidden">
                            @if($simImg)
                                <img src="{{ asset('storage/' . $simImg->image_path) }}" alt="{{ $similar->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-700">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="text-sm font-bold text-gray-100 truncate mb-1 group-hover:text-amber-400 transition-colors">{{ $similar->title }}</h4>
                            <p class="text-amber-400 font-extrabold text-sm">₹{{ number_format($similar->price) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection