<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    /**
     * Get subcategories for a given parent category.
     */
    public function getSubcategories(int $categoryId): JsonResponse
    {
        $subcategories = Category::where('parent_id', $categoryId)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        return response()->json($subcategories);
    }
}
