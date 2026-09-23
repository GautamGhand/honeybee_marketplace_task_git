@extends('layouts.app')

@section('title', 'My Listings - HoneyBee Market')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 16px;">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">
                My <span class="text-amber-400">Listings</span>
            </h1>
            <p class="text-sm text-gray-400 mt-1">Manage all your posted advertisements</p>
        </div>
        <div>
            <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post New Ad
            </a>
        </div>
    </div>

    {{-- Session Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Listings Grid / Table --}}
    @if(isset($listings) && $listings->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($listings as $listing)
                <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden shadow-xl flex flex-col justify-between">
                    <div>
                        {{-- Image / Placeholder --}}
                        <div class="h-48 w-full bg-gray-800 relative overflow-hidden">
                           @if($listing->images && $listing->images->count() > 0)
                                <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @else
                                {{-- Fallback default image --}}
                                <img src="{{ asset('images/placeholder.png') }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @endif
                            <span class="absolute top-3 right-3 bg-gray-950/80 backdrop-blur-md text-amber-400 font-bold px-3 py-1 rounded-lg text-xs border border-gray-800">
                                ₹{{ number_format($listing->price ?? 0) }}
                            </span>
                        </div>

                        {{-- Details --}}
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-100 truncate mb-1">{{ $listing->title }}</h3>
                            <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $listing->description }}</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 pt-0 flex items-center gap-2 border-t border-gray-800/60 mt-2">
                        <a href="{{ route('listings.edit', $listing->id) }}" class="flex-1 text-center bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs font-semibold py-2.5 rounded-xl border border-gray-700 transition-colors">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(method_exists($listings, 'links'))
            <div class="mt-8">
                {{ $listings->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="text-center py-16 bg-gray-900 border border-gray-800 rounded-3xl">
            <svg class="w-16 h-16 mx-auto text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <h3 class="text-lg font-semibold text-gray-300 mb-1">No listings found</h3>
            <p class="text-sm text-gray-500 mb-6">You haven't posted any advertisements yet.</p>
            <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold px-6 py-3 rounded-xl transition-all text-sm">
                Post Your First Ad
            </a>
        </div>
    @endif

</div>
@endsection