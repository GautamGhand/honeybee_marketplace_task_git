<script>
// Function ko global scope me rakhein taaki inline onclick handler ise dhoond sake
function selectListingType(type) {
    const btnProduct = document.getElementById('btn_type_product');
    const btnService = document.getElementById('btn_type_service');
    const inputProduct = document.getElementById('type_product');
    const inputService = document.getElementById('type_service');

    if (!btnProduct || !btnService || !inputProduct || !inputService) return;

    const activeClasses = ['bg-amber-500/10', 'border-amber-500', 'text-amber-400', 'shadow-md'];
    const inactiveClasses = ['bg-gray-800/80', 'border-gray-700', 'text-gray-400'];

    if (type === 'product') {
        inputProduct.checked = true;
        inputService.checked = false;

        btnProduct.classList.add(...activeClasses);
        btnProduct.classList.remove(...inactiveClasses);

        btnService.classList.remove(...activeClasses);
        btnService.classList.add(...inactiveClasses);
    } else {
        inputService.checked = true;
        inputProduct.checked = false;

        btnService.classList.add(...activeClasses);
        btnService.classList.remove(...inactiveClasses);

        btnProduct.classList.remove(...activeClasses);
        btnProduct.classList.add(...inactiveClasses);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Page load par initial active state set karne ke liye
    const checkedInput = document.querySelector('input[name="type"]:checked');
    const selectedType = checkedInput ? checkedInput.value : 'product';
    selectListingType(selectedType);

    // Dynamic Cascading Dropdowns JavaScript...
    const categorySelect = document.getElementById('category_id');
    const subcategorySelect = document.getElementById('subcategory_id');
    const countrySelect = document.getElementById('country_id');
    const stateSelect = document.getElementById('state_id');
    const citySelect = document.getElementById('city_id');
    const areaSelect = document.getElementById('area_id');

    const allSubcategories = Array.from(subcategorySelect?.querySelectorAll('option[data-parent]') || []);
    const allStates = Array.from(stateSelect?.querySelectorAll('option[data-parent]') || []);
    const allCities = Array.from(citySelect?.querySelectorAll('option[data-parent]') || []);
    const allAreas = Array.from(areaSelect?.querySelectorAll('option[data-parent]') || []);

    function filterOptions(selectElem, options, parentId, defaultText, isInitial = false) {
        if (!selectElem) return;
        const currentVal = selectElem.value;

        selectElem.innerHTML = `<option value="" disabled selected>${defaultText}</option>`;

        const matchingOptions = options.filter(opt => opt.dataset.parent === String(parentId));
        matchingOptions.forEach(opt => selectElem.appendChild(opt.cloneNode(true)));

        if (isInitial && currentVal) {
            selectElem.value = currentVal;
        } else {
            selectElem.selectedIndex = 0;
        }
    }

    categorySelect?.addEventListener('change', function () {
        filterOptions(subcategorySelect, allSubcategories, this.value, 'Select Subcategory');
    });

    countrySelect?.addEventListener('change', function () {
        filterOptions(stateSelect, allStates, this.value, 'Select State');
        filterOptions(citySelect, [], null, 'Select City');
        filterOptions(areaSelect, [], null, 'Select Area (Optional)');
    });

    stateSelect?.addEventListener('change', function () {
        filterOptions(citySelect, allCities, this.value, 'Select City');
        filterOptions(areaSelect, [], null, 'Select Area (Optional)');
    });

    citySelect?.addEventListener('change', function () {
        filterOptions(areaSelect, allAreas, this.value, 'Select Area (Optional)');
    });

    if (categorySelect?.value) filterOptions(subcategorySelect, allSubcategories, categorySelect.value, 'Select Subcategory', true);
    if (countrySelect?.value) filterOptions(stateSelect, allStates, countrySelect.value, 'Select State', true);
    if (stateSelect?.value) filterOptions(citySelect, allCities, stateSelect.value, 'Select City', true);
    if (citySelect?.value) filterOptions(areaSelect, allAreas, citySelect.value, 'Select Area (Optional)', true);
});
</script>