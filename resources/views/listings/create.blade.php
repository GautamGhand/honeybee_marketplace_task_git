@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-xl font-bold text-white">Create New Listing</h1>
            <p class="text-xs text-gray-400 mt-1">Fill out the details below to publish your item or service.</p>
        </div>

        <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

           {{-- Type Selection --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Listing Type</label>
                <div class="grid grid-cols-2 gap-4">
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
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Modern Office Desk"
                        class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                    @error('title')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Price (₹)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" placeholder="0.00"
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
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subcategory_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Subcategory</label>
                    <select id="subcategory_id" name="subcategory_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled {{ old('subcategory_id') ? '' : 'selected' }}>Select Subcategory</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
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
                        <option value="" disabled {{ old('country_id') ? '' : 'selected' }}>Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="state_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">State</label>
                    <select id="state_id" name="state_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled {{ old('state_id') ? '' : 'selected' }}>Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" data-parent="{{ $state->parent_id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="city_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">City</label>
                    <select id="city_id" name="city_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled {{ old('city_id') ? '' : 'selected' }}>Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" data-parent="{{ $city->parent_id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="area_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Area (Optional)</label>
                    <select id="area_id" name="area_id" class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                        <option value="" disabled {{ old('area_id') ? '' : 'selected' }}>Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" data-parent="{{ $area->parent_id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Provide detailed details about your product or service..."
                    class="w-full bg-gray-800/80 text-gray-200 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Images --}}
            <div>
                <label for="images" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Images</label>
                <input id="images" type="file" name="images[]" multiple accept="image/*"
                    class="w-full bg-gray-800/80 text-gray-300 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-gray-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer">
                @error('images.*')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800">
                <a href="{{ route('listings.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-700 text-gray-300 text-sm hover:bg-gray-800 transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-gray-950 font-semibold text-sm transition">Publish Listing</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@include('listings.partials._form-scripts')
@endpush
@endsection