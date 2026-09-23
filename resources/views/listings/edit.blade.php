@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-xl font-bold text-white">Edit Listing</h1>
            <p class="text-xs text-gray-400 mt-1">Update details for "{{ $listing->title }}"</p>
        </div>

        <form action="{{ route('listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

           {{-- Type Selection --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Listing Type</label>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{-- Product Box --}}
                    <label id="btn_type_product" onclick="selectListingType('product')" 
                        class="p-4 rounded-xl border text-center font-medium cursor-pointer transition-all duration-200">
                        <input type="radio" id="type_product" name="type" value="product" class="hidden" 
                            {{ old('type', $listing->type ?? 'product') === 'product' ? 'checked' : '' }}>
                        <span class="block text-sm font-bold">Product</span>
                        <span class="block text-xs opacity-75 mt-0.5">Physical items to buy or sell</span>
                    </label>

                    {{-- Service Box --}}
                    <label id="btn_type_service" onclick="selectListingType('service')" 
                        class="p-4 rounded-xl border text-center font-medium cursor-pointer transition-all duration-200">
                        <input type="radio" id="type_service" name="type" value="service" class="hidden" 
                            {{ old('type', $listing->type ?? '') === 'service' ? 'checked' : '' }}>
                        <span class="block text-sm font-bold">Service</span>
                        <span class="block text-xs opacity-75 mt-0.5">Professional or local services</span>
                    </label>
                </div>
                @error('type')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Basic Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $listing->title) }}"
                        class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                    @error('title')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Price (₹)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $listing->price) }}"
                        class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                    @error('price')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Category & Subcategory --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Category</label>
                    <select id="category_id" name="category_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subcategory_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Subcategory</label>
                    <select id="subcategory_id" name="subcategory_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select Subcategory</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}" {{ old('subcategory_id', $listing->subcategory_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Location Cascade --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="country_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Country</label>
                    <select id="country_id" name="country_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $listing->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="state_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">State</label>
                    <select id="state_id" name="state_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" data-parent="{{ $state->parent_id }}" {{ old('state_id', $listing->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="city_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">City</label>
                    <select id="city_id" name="city_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" data-parent="{{ $city->parent_id }}" {{ old('city_id', $listing->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="area_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Area (Optional)</label>
                    <select id="area_id" name="area_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled>Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" data-parent="{{ $area->parent_id }}" {{ old('area_id', $listing->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">{{ old('description', $listing->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Existing Images Preview & Upload New --}}
            <div>
                <label for="images" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Listing Images</label>
                
                @if(!empty($listing->images) || $listing->image_path)
                    <div class="mb-3 p-3 bg-gray-800/50 rounded-xl border border-gray-700">
                        <p class="text-xs text-gray-400 mb-2">Existing Uploads:</p>
                        <div class="flex items-center gap-3 flex-wrap">
                            @if(is_iterable($listing->images))
                                @foreach($listing->images as $img)
                                    <img src="{{ asset('storage/' . (is_string($img) ? $img : $img->image_path)) }}" 
                                         alt="Listing Image" class="w-14 h-14 object-cover rounded-lg border border-gray-700">
                                @endforeach
                            @elseif($listing->image_path)
                                <img src="{{ asset('storage/' . $listing->image_path) }}" 
                                     alt="Listing Image" class="w-14 h-14 object-cover rounded-lg border border-gray-700">
                            @endif
                        </div>
                    </div>
                @endif

                <input id="images" type="file" name="images[]" multiple accept="image/*"
                    class="w-full bg-gray-800/80 text-gray-300 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-gray-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer">
                <p class="text-[11px] text-gray-500 mt-1">Uploading new files will append or replace your current images.</p>
                @error('images.*')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex flex-col gap-3 border-t border-gray-800 pt-4 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('listings.index') }}" class="w-full px-5 py-2.5 text-center rounded-xl border border-gray-700 text-gray-300 text-sm hover:bg-gray-800 transition sm:w-auto">Cancel</a>
                <button type="submit" class="w-full px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-gray-950 font-semibold text-sm transition sm:w-auto">Update Listing</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@include('listings.partials._form-scripts')
@endpush
@endsection
