<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CategorySubcategoryPageTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_parent_category_page_renders_its_subcategories(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'sort_order' => 1,
        ]);

        $subcategory = Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'parent_id' => $category->id,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('listings.category', $category->slug));

        $response->assertSeeText('Choose a subcategory')
            ->assertSeeText($subcategory->name)
            ->assertSee(route('listings.subcategory', [$category->slug, $subcategory->slug]), false);
    }

    public function test_subcategory_route_requires_its_parent_category(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'sort_order' => 1,
        ]);

        $otherCategory = Category::create([
            'name' => 'Vehicles',
            'slug' => 'vehicles',
            'sort_order' => 2,
        ]);

        $subcategory = Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'parent_id' => $category->id,
            'sort_order' => 1,
        ]);

        $this->get(route('listings.subcategory', [$otherCategory->slug, $subcategory->slug]))
            ->assertNotFound();
    }
}
