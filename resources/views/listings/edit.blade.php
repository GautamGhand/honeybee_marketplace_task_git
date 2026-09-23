@extends('layouts.app')

@section('title', 'Edit Listing - HoneyBee Market')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 16px;">
    <div style="width: 100%; max-width: 650px; margin: 0 auto;">
        
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

                {{-- Listing Type --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Listing Type
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer" onclick="selectListingType('product')">
                            <input type="radio" name="type" id="type_product" value="product" class="hidden" {{ old('type', $listing->type ?? 'product') == 'product' ? 'checked' : '' }}>
                            <div id="btn_type_product" class="p-3 text-center rounded-xl bg-gray-800/80 border text-gray-400 font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                <span>🛒</span> Product
                            </div>
                        </label>
                        
                        <label class="cursor-pointer" onclick="selectListingType('service')">
                            <input type="radio" name="type" id="type_service" value="service" class="hidden" {{ old('type', $listing->type) == 'service' ? 'checked' : '' }}>
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
                    <input id="title" type="text" name="title" value="{{ old('title', $listing->title) }}" required
                        placeholder="e.g. iPhone 13 Pro 128GB - Excellent Condition"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Subcategory --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                            Category
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none @error('category_id') border-red-500 @enderror">
                            <option value="" disabled>Select Category</option>
                            @foreach($categories->whereNull('parent_id') as$category)
                                <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) ==$category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subcategory_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                            Subcategory
                        </label>
                        <select id="subcategory_id" name="subcategory_id"
                            class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none @error('subcategory_id') border-red-500 @enderror">
                            <option value="" disabled selected>Select Subcategory</option>
                            @foreach($categories->whereNotNull('parent_id') as$subCategory)
                                <option value="{{ $subCategory->id }}" data-parent="{{ $subCategory->parent_id }}" {{ old('subcategory_id', $listing->subcategory_id ?? '') == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
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

                {{-- Location Section (Cascading Dropdowns) --}}
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
                                <option value="" disabled>Select Country</option>
                                @foreach($locations->where('type', 'country') as$country)
                                    <option value="{{ $country->id }}" {{ old('country_id', $listing->country_id) ==$country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- State --}}
                        <div>
                            <label for="state_id" class="block text-[11px] text-gray-400 mb-1">State</label>
                            <select id="state_id" name="state_id" required
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="" disabled>Select State</option>
                                @foreach($locations->where('type', 'state') as$state)
                                    <option value="{{ $state->id }}" data-parent="{{ $state->parent_id }}" {{ old('state_id', $listing->state_id) ==$state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label for="city_id" class="block text-[11px] text-gray-400 mb-1">City</label>
                            <select id="city_id" name="city_id" required
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="" disabled>Select City</option>
                                @foreach($locations->where('type', 'city') as$city)
                                    <option value="{{ $city->id }}" data-parent="{{ $city->parent_id }}" {{ old('city_id', $listing->city_id) ==$city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-[10px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Area --}}
                        <div>
                            <label for="area_id" class="block text-[11px] text-gray-400 mb-1">Area / Locality</label>
                            <select id="area_id" name="area_id"
                                class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-3 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none">
                                <option value="">Select Area (Optional)</option>
                                @foreach($locations->where('type', 'area') as$area)
                                    <option value="{{ $area->id }}" data-parent="{{ $area->parent_id }}" {{ old('area_id', $listing->area_id) ==$area->id ? 'selected' : '' }}>
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
                        placeholder="Describe what you are selling..."
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700 focus:border-amber-500 focus:outline-none placeholder-gray-500 @error('description') border-red-500 @enderror">{{ old('description', $listing->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image Upload & Current Image Preview --}}
                <div>
                    <label for="images" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Product Images
                    </label>

                    @if($listing->image_path || ($listing->images && count($listing->images) > 0))
                        <div class="mb-3 p-3 bg-gray-800/50 rounded-xl border border-gray-700">
                            <p class="text-xs text-gray-300 font-medium mb-2">Current Image(s)</p>
                            <div class="flex items-center gap-3">
                                @if(is_array($listing->images) \vert{}\vert{} is_object($listing->images))
                                    @foreach($listing->images as$img)
                                        <img src="{{ asset('storage/' . (is_string($img) ? $img :$img->image_path)) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-700">
                                    @endforeach
                                @else
                                    <img src="{{ asset('storage/' . $listing->image_path) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-700">
                                @endif
                            </div>
                        </div>
                    @endif

                    <input id="images" type="file" name="images[]" multiple accept="image/*"
                        class="w-full bg-gray-800/80 text-gray-300 text-sm rounded-xl px-4 py-2.5 border border-gray-700 focus:border-amber-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-gray-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer">
                    <p class="text-[11px] text-gray-500 mt-1">Uploading new images will append/replace existing photos.</p>
                    @error('images.*')
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

<script>
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

    document.addEventListener('DOMContentLoaded', function () {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value || 'product';
        selectListingType(selectedType);

        // Category & Subcategory Elements
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const allSubcategories = Array.from(subcategorySelect.querySelectorAll('option[data-parent]'));

        // Location Elements
        const countrySelect = document.getElementById('country_id');
        const stateSelect = document.getElementById('state_id');
        const citySelect = document.getElementById('city_id');
        const areaSelect = document.getElementById('area_id');

        const allStates = Array.from(stateSelect.querySelectorAll('option[data-parent]'));
        const allCities = Array.from(citySelect.querySelectorAll('option[data-parent]'));
        const allAreas = Array.from(areaSelect.querySelectorAll('option[data-parent]'));

        const targetCategoryId = "{{ old('category_id', $listing->category_id) }}";
        const targetSubcategoryId = "{{ old('subcategory_id', $listing->subcategory_id ?? '') }}";

        const targetStateId = "{{ old('state_id', $listing->state_id) }}";
        const targetCityId = "{{ old('city_id', $listing->city_id) }}";
        const targetAreaId = "{{ old('area_id', $listing->area_id) }}";

        function filterOptions(selectElem, options, parentId, defaultText, targetValue = null) {
            selectElem.innerHTML = `<option value="" disabled selected>${defaultText}</option>`;
            options.filter(opt => opt.dataset.parent === String(parentId))
                   .forEach(opt => selectElem.appendChild(opt.cloneNode(true)));
            if (targetValue) selectElem.value = targetValue;
        }

        // Initialize category & subcategory preselection for Edit
        if (targetCategoryId) {
            filterOptions(subcategorySelect, allSubcategories, targetCategoryId, 'Select Subcategory', targetSubcategoryId);
        }

        // Initialize location preselection for Edit
        if (countrySelect.value) {
            filterOptions(stateSelect, allStates, countrySelect.value, 'Select State', targetStateId);
        }
        if (targetStateId) {
            filterOptions(citySelect, allCities, targetStateId, 'Select City', targetCityId);
        }
        if (targetCityId) {
            filterOptions(areaSelect, allAreas, targetCityId, 'Select Area (Optional)', targetAreaId);
        }

        // On Category change
        categorySelect.addEventListener('change', function () {
            filterOptions(subcategorySelect, allSubcategories, this.value, 'Select Subcategory');
        });

        // On Location changes
        countrySelect.addEventListener('change', function () {
            filterOptions(stateSelect, allStates, this.value, 'Select State');
            citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';
            areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
        });

        stateSelect.addEventListener('change', function () {
            filterOptions(citySelect, allCities, this.value, 'Select City');
            areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
        });

        citySelect.addEventListener('change', function () {
            filterOptions(areaSelect, allAreas, this.value, 'Select Area (Optional)');
        });
    });
</script>
@endsection