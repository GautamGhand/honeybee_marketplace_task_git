@extends('layouts.app')

@section('title', $category->name . ' Subcategories - HoneyBee Market')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-amber-400 transition-colors">
        <span aria-hidden="true">&larr;</span>
        All Categories
    </a>

    <div class="mt-6 mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-amber-400">Browse {{ $category->name }}</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">Choose a subcategory</h1>
        <p class="mt-2 text-sm text-gray-400">Find exactly what you are looking for.</p>
    </div>

    @if ($category->children->isNotEmpty())
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($category->children as $subcategory)
                <a href="{{ route('listings.subcategory', [$category->slug, $subcategory->slug]) }}"
                   class="group rounded-2xl border border-gray-800/50 bg-gray-900/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-amber-500/30 hover:shadow-xl hover:shadow-amber-500/5">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-base font-semibold text-gray-200 transition-colors group-hover:text-amber-400">{{ $subcategory->name }}</h2>
                        <span class="text-xl text-gray-600 transition-colors group-hover:text-amber-400" aria-hidden="true">&rarr;</span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-gray-800 bg-gray-900/50 px-6 py-12 text-center">
            <h2 class="text-lg font-semibold text-gray-300">No subcategories available</h2>
            <p class="mt-2 text-sm text-gray-500">Please check back later.</p>
        </div>
    @endif
</section>
@endsection
