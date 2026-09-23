@extends('layouts.app')

@section('title', 'Post New Ad - HoneyBee Market')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 16px;">
    
    {{-- Main Container --}}
    <div style="width: 100%; max-width: 650px; margin: 0 auto;">
        
        {{-- Header --}}
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Post <span class="text-amber-400">New Ad</span>
            </h2>
            <p class="text-sm text-gray-400 mt-2">Reach thousands of buyers in your local community</p>
        </div>

        {{-- Form Box --}}
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
            
            <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Listing Type (Product vs Service) --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Listing Type
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer" onclick="selectListingType('product')">
                            <input type="radio" name="type" id="type_product" value="product" class="hidden" {{ old('type', 'product') == 'product' ? 'checked' : '' }}>
                            <div id="btn_type_product" class="p-3 text-center rounded-xl bg-gray-800/80 border text-gray-400 font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                <span>🛒</span> Product
                            </div>
                        </label>
                        
                        <label class="cursor-pointer" onclick="selectListingType('service')">
                            <input type="radio" name="type" id="type_service" value="service" class="hidden" {{ old('type') == 'service' ? 'checked' : '' }}>
                            <div id="btn_type_service" class="p-3 text-center rounded-xl bg-gray-800/80 border text-gray-400 font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                <span>🛠️</span> Service
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Listing Title --}}
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Title
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                        placeholder="e.g. iPhone 14 Pro Max 256GB - Brand New"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Price --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                            Category
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none @error('category_id') border-red-500 @enderror">
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}" required
                            placeholder="e.g. 5000"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Location Section (Country -> State -> City -> Area) --}}
                <div class="space-y-3 pt-1">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-amber-400">
                        📍 Location Details
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Country --}}
                        <div>
                            <label for="country_id" class="block text-[11px] text-gray-400 mb-1">Country</label>
                            <select id="country_id" name="country_id" required
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="" disabled selected>Select Country</option>
                                @foreach($locations->where('type', 'country') as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- State (Parent: Country) --}}
                        <div>
                            <label for="state_id" class="block text-[11px] text-gray-400 mb-1">State</label>
                            <select id="state_id" name="state_id" required
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="" disabled selected>Select State</option>
                                @foreach($locations->where('type', 'state') as $state)
                                    <option value="{{ $state->id }}" data-parent="{{ $state->parent_id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- City (Parent: State) --}}
                        <div>
                            <label for="city_id" class="block text-[11px] text-gray-400 mb-1">City</label>
                            <select id="city_id" name="city_id" required
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="" disabled selected>Select City</option>
                                @foreach($locations->where('type', 'city') as $city)
                                    <option value="{{ $city->id }}" data-parent="{{ $city->parent_id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Area (Parent: City) --}}
                        <div>
                            <label for="area_id" class="block text-[11px] text-gray-400 mb-1">Area / Locality</label>
                            <select id="area_id" name="area_id"
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="">Select Area (Optional)</option>
                                @foreach($locations->where('type', 'area') as $area)
                                    <option value="{{ $area->id }}" data-parent="{{ $area->parent_id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        placeholder="Provide details like item condition, features, reason for sale..."
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div>
                    <label for="images" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Upload Photos
                    </label>
                    <input id="images" type="file" name="images[]" multiple accept="image/*"
                        class="w-full bg-gray-800/80 text-gray-300 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-gray-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer">
                    <p class="text-[11px] text-gray-500 mt-1">First selected image will be the cover thumbnail.</p>
                    @error('images.*')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm">
                        Publish Advertisement
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

{{-- Dynamic Scripts --}}
<script>
    // Listing Type Button Switcher
    function selectListingType(type) {
        const btnProduct = document.getElementById('btn_type_product');
        const btnService = document.getElementById('btn_type_service');
        const inputProduct = document.getElementById('type_product');
        const inputService = document.getElementById('type_service');

        const activeClasses = ['bg-amber-500/10', 'border-amber-500', 'text-amber-400', 'shadow-md'];
        const inactiveClasses = ['bg-gray-800/80', 'border-gray-700', 'text-gray-400'];

        if (type === 'product') {
            inputProduct.checked = true;
            btnProduct.classList.add(...activeClasses);
            btnProduct.classList.remove(...inactiveClasses);
            btnService.classList.remove(...activeClasses);
            btnService.classList.add(...inactiveClasses);
        } else {
            inputService.checked = true;
            btnService.classList.add(...activeClasses);
            btnService.classList.remove(...inactiveClasses);
            btnProduct.classList.remove(...activeClasses);
            btnProduct.classList.add(...inactiveClasses);
        }
    }

    // Dynamic 4-Level Cascading Dropdowns: Country -> State -> City -> Area
    document.addEventListener('DOMContentLoaded', function () {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value || 'product';
        selectListingType(selectedType);

        const countrySelect = document.getElementById('country_id');
        const stateSelect = document.getElementById('state_id');
        const citySelect = document.getElementById('city_id');
        const areaSelect = document.getElementById('area_id');

        const allStates = Array.from(stateSelect.querySelectorAll('option[data-parent]'));
        const allCities = Array.from(citySelect.querySelectorAll('option[data-parent]'));
        const allAreas = Array.from(areaSelect.querySelectorAll('option[data-parent]'));

        countrySelect.addEventListener('change', function () {
            const selectedCountryId = this.value;

            // Filter States based on Country parent_id
            stateSelect.innerHTML = '<option value="" disabled selected>Select State</option>';
            allStates.filter(opt => opt.dataset.parent === selectedCountryId)
                     .forEach(opt => stateSelect.appendChild(opt.cloneNode(true)));

            // Reset Cities & Areas
            citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
            areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
        });

        stateSelect.addEventListener('change', function () {
            const selectedStateId = this.value;

            // Filter Cities based on State parent_id
            citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
            allCities.filter(opt => opt.dataset.parent === selectedStateId)
                     .forEach(opt => citySelect.appendChild(opt.cloneNode(true)));

            // Reset Area
            areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
        });

        citySelect.addEventListener('change', function () {
            const selectedCityId = this.value;

            // Filter Areas based on City parent_id
            areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
            allAreas.filter(opt => opt.dataset.parent === selectedCityId)
                    .forEach(opt => areaSelect.appendChild(opt.cloneNode(true)));
        });
    });
</script>
@endsection