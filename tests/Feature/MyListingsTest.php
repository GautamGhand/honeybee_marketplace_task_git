<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class MyListingsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_my_listings_links_each_listing_to_its_public_detail_page(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'sort_order' => 1,
        ]);
        $country = Location::create([
            'name' => 'India',
            'slug' => 'india',
            'type' => 'country',
        ]);
        $state = Location::create([
            'name' => 'Karnataka',
            'slug' => 'karnataka',
            'type' => 'state',
            'parent_id' => $country->id,
        ]);
        $city = Location::create([
            'name' => 'Bengaluru',
            'slug' => 'bengaluru',
            'type' => 'city',
            'parent_id' => $state->id,
        ]);
        $listing = Listing::create([
            'user_id' => $user->id,
            'type' => 'product',
            'title' => 'MacBook Air M2 - 8GB/256GB Space Gray',
            'slug' => 'macbook-air-m2-8gb256gb-space-gray',
            'description' => 'A fully working MacBook Air in excellent condition.',
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'price' => 12000,
        ]);

        $this->assertSame('macbook-air-m2-8gb256gb-space-gray', $listing->slug);

        $this->actingAs($user)
            ->get(route('listings.mine'))
            ->assertSee(route('listings.show', $listing->slug), false);

        $this->get(route('listings.show', $listing->slug))
            ->assertSeeText($listing->title);
    }
}
