{{-- Listing Card Component --}}
{{-- Usage: @include('components.listing-card', ['listing' => $listing]) --}}
<a href="{{ route('listings.show', $listing->slug) }}" class="group block bg-gray-900/50 border border-gray-800/50 rounded-2xl overflow-hidden hover:border-amber-500/30 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-300 hover:-translate-y-1" id="listing-card-{{ $listing->id }}">
    {{-- Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-800">
        <img src="{{ $listing->primary_image_url }}"
             alt="{{ $listing->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
             loading="lazy">

        {{-- Price Badge --}}
        <div class="absolute bottom-3 left-3 bg-amber-500/90 backdrop-blur-sm text-gray-900 font-bold text-sm px-3 py-1 rounded-lg shadow-lg">
            {{ $listing->formatted_price }}
        </div>

        {{-- Type Badge --}}
        @if($listing->type === 'service')
        <div class="absolute top-3 right-3 bg-blue-500/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-lg">
            Service
        </div>
        @endif

        {{-- Featured Badge --}}
        @if($listing->is_featured)
        <div class="absolute top-3 left-3 bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900 text-xs font-bold px-2.5 py-1 rounded-lg flex items-center gap-1">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Featured
        </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4">
        <h3 class="text-sm font-semibold text-gray-200 group-hover:text-amber-400 transition-colors line-clamp-1 mb-1">
            {{ $listing->title }}
        </h3>

        <p class="text-xs text-gray-500 line-clamp-2 mb-3 leading-relaxed">
            {{ Str::limit($listing->description, 80) }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1 text-xs text-gray-500">
                <svg class="w-3 h-3 text-amber-500/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $listing->city->name ?? 'Unknown' }}
            </div>
            <span class="text-xs text-gray-600">
                {{ $listing->created_at->diffForHumans() }}
            </span>
        </div>

        {{-- Category Tag --}}
        <div class="mt-3 pt-3 border-t border-gray-800/50">
            <span class="inline-block text-xs bg-gray-800/80 text-amber-400/80 px-2.5 py-1 rounded-md font-medium">
                {{ $listing->category->name }}
            </span>
        </div>
    </div>
</a>
