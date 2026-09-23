<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'icon' => 'device-mobile',
                'children' => ['Mobile Phones', 'Laptops', 'Tablets', 'Cameras', 'TV & Audio', 'Accessories', 'Gaming Consoles'],
            ],
            [
                'name' => 'Vehicles',
                'icon' => 'car',
                'children' => ['Cars', 'Motorcycles', 'Scooters', 'Bicycles', 'Auto Parts', 'Commercial Vehicles'],
            ],
            [
                'name' => 'Property',
                'icon' => 'building',
                'children' => ['Apartments', 'Houses & Villas', 'Land & Plots', 'Commercial Space', 'PG & Hostel', 'Shops & Offices'],
            ],
            [
                'name' => 'Fashion',
                'icon' => 'shirt',
                'children' => ['Men\'s Fashion', 'Women\'s Fashion', 'Kids\' Fashion', 'Watches', 'Shoes', 'Bags & Luggage'],
            ],
            [
                'name' => 'Jobs',
                'icon' => 'briefcase',
                'children' => ['IT & Software', 'Marketing', 'Sales', 'Finance', 'Education', 'Healthcare', 'Customer Service'],
            ],
            [
                'name' => 'Services',
                'icon' => 'wrench',
                'children' => ['Home Repair', 'Cleaning', 'Tutoring', 'Beauty & Spa', 'Movers & Packers', 'Legal', 'Freelance'],
            ],
            [
                'name' => 'Furniture',
                'icon' => 'armchair',
                'children' => ['Sofas', 'Beds', 'Tables', 'Chairs', 'Wardrobes', 'Kitchen Furniture', 'Office Furniture'],
            ],
            [
                'name' => 'Pets',
                'icon' => 'paw',
                'children' => ['Dogs', 'Cats', 'Fish', 'Birds', 'Pet Food & Accessories', 'Pet Services'],
            ],
        ];

        foreach ($categories as $index => $categoryData) {
            $parent = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'icon' => $categoryData['icon'],
                'sort_order' => $index,
            ]);

            foreach ($categoryData['children'] as $childIndex => $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'icon' => null,
                    'parent_id' => $parent->id,
                    'sort_order' => $childIndex,
                ]);
            }
        }
    }
}
