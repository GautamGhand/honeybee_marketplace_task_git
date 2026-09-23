@extends('layouts.app')

@section('title', 'Edit Listing - HoneyBee Market')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 16px;">
    
    {{-- Main Container --}}
    <div style="width: 100%; max-width: 600px; margin: 0 auto;">
        
        {{-- Header --}}
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Edit <span class="text-amber-400">Listing</span>
            </h2>
            <p class="text-sm text-gray-400 mt-2">Update details of your advertisement</p>
        </div>

        {{-- Form Box --}}
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
            
            <form method="POST" action="{{ route('listings.update', $listing->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Listing Title --}}
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Title
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title', $listing->title) }}" required
                        placeholder="e.g. iPhone 13 Pro 128GB - Excellent Condition"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Price (Grid) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                            Category
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none @error('category_id') border-red-500 @enderror">
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                            Price (₹)
                        </label>
                        <input id="price" type="number" step="0.01" name="price" value="{{ old('price', $listing->price) }}" required
                            placeholder="e.g. 45000"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        placeholder="Describe what you are selling, product condition, reason for selling, etc."
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('description') border-red-500 @enderror">{{ old('description', $listing->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label for="location" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Location / City
                    </label>
                    <input id="location" type="text" name="location" value="{{ old('location', $listing->location) }}" required
                        placeholder="e.g. Mumbai, Maharashtra"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image Upload & Current Image Preview --}}
                <div>
                    <label for="image" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Product Image
                    </label>

                    @if($listing->image_path ?? false)
                        <div class="mb-3 flex items-center gap-4 p-3 bg-gray-800/50 rounded-xl border border-gray-700">
                            <img src="{{ asset('storage/' . $listing->image_path) }}" alt="Current image" class="w-16 h-16 object-cover rounded-lg border border-gray-700">
                            <div>
                                <p class="text-xs text-gray-300 font-medium">Current Image</p>
                                <p class="text-[11px] text-gray-500">Upload a new file below to replace it.</p>
                            </div>
                        </div>
                    @endif

                    <input id="image" type="file" name="image" accept="image/*"
                        class="w-full bg-gray-800/80 text-gray-300 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-gray-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer">
                    @error('image')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('listings.mine') }}" class="flex-1 text-center bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-3.5 px-4 rounded-xl border border-gray-700 transition-colors text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm">
                        Update Ad
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection