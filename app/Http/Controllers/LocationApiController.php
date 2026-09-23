<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationApiController extends Controller
{
    /**
     * Get states for a given country.
     */
    public function getStates(int $countryId): JsonResponse
    {
        $states = Location::where('parent_id', $countryId)
            ->where('type', 'state')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json($states);
    }

    /**
     * Get cities for a given state.
     */
    public function getCities(int $stateId): JsonResponse
    {
        $cities = Location::where('parent_id', $stateId)
            ->where('type', 'city')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json($cities);
    }

    /**
     * Get areas for a given city.
     */
    public function getAreas(int $cityId): JsonResponse
    {
        $areas = Location::where('parent_id', $cityId)
            ->where('type', 'area')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json($areas);
    }
}
