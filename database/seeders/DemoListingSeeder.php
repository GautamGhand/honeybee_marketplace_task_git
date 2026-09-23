<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo users
        $users = [];
        $demoUsers = [
            ['name' => 'Rahul Sharma', 'email' => 'rahul@demo.com', 'phone' => '9876543210'],
            ['name' => 'Priya Patel', 'email' => 'priya@demo.com', 'phone' => '9876543211'],
            ['name' => 'Amit Kumar', 'email' => 'amit@demo.com', 'phone' => '9876543212'],
            ['name' => 'Sneha Reddy', 'email' => 'sneha@demo.com', 'phone' => '9876543213'],
            ['name' => 'Vikram Singh', 'email' => 'vikram@demo.com', 'phone' => '9876543214'],
        ];

        foreach ($demoUsers as $userData) {
            $users[] = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'password' => Hash::make('password123'),
            ]);
        }

        // Get some categories and locations for listings
        $india = Location::where('slug', 'india')->first();
        $states = Location::where('type', 'state')->get();

        $demoListings = [
            // Electronics
            [
                'type' => 'product',
                'title' => 'iPhone 15 Pro Max - 256GB Natural Titanium',
                'description' => 'Brand new iPhone 15 Pro Max in excellent condition. 256GB storage, Natural Titanium color. Comes with original box, charger, and all accessories. Battery health 100%. Still under Apple warranty until March 2025. No scratches or dents.',
                'category' => 'Electronics',
                'subcategory' => 'Mobile Phones',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Andheri',
                'price' => 119999,
            ],
            [
                'type' => 'product',
                'title' => 'MacBook Air M2 - 8GB/256GB Space Gray',
                'description' => 'MacBook Air M2 chip, 13.6" Liquid Retina display. 8GB RAM, 256GB SSD. Excellent condition, barely used for 3 months. Comes with MagSafe charger and original box. Perfect for students and professionals.',
                'category' => 'Electronics',
                'subcategory' => 'Laptops',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'Koramangala',
                'price' => 82000,
            ],
            [
                'type' => 'product',
                'title' => 'Sony WH-1000XM5 Wireless Headphones',
                'description' => 'Premium noise-cancelling headphones. Industry-leading noise cancellation with Auto NC Optimizer. Crystal clear hands-free calling with 4 beamforming microphones. 30-hour battery life.',
                'category' => 'Electronics',
                'subcategory' => 'Accessories',
                'state' => 'Delhi',
                'city' => 'New Delhi',
                'area' => 'Connaught Place',
                'price' => 22990,
            ],
            // Vehicles
            [
                'type' => 'product',
                'title' => 'Royal Enfield Classic 350 - 2023 Model',
                'description' => 'Royal Enfield Classic 350 in Dark Stealth Black. Single owner, only 5000 km driven. All service records available. New tires, recently serviced. Insurance valid until Dec 2025.',
                'category' => 'Vehicles',
                'subcategory' => 'Motorcycles',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'area' => 'C-Scheme',
                'price' => 175000,
            ],
            [
                'type' => 'product',
                'title' => 'Maruti Suzuki Swift VXI 2022 - Petrol',
                'description' => 'Maruti Swift VXI petrol variant. Pearl Arctic White color. First owner, only 15000 km driven. Comprehensive insurance. All original documents available. Well maintained with regular servicing at authorized service center.',
                'category' => 'Vehicles',
                'subcategory' => 'Cars',
                'state' => 'Gujarat',
                'city' => 'Ahmedabad',
                'area' => 'SG Highway',
                'price' => 650000,
            ],
            // Property
            [
                'type' => 'product',
                'title' => '2 BHK Apartment in Bandra West',
                'description' => 'Spacious 2 BHK apartment in prime Bandra West location. 850 sq ft carpet area. Sea-facing balcony. Semi-furnished with modular kitchen and wardrobes. 24/7 security, gym, swimming pool. Close to Bandra station and Linking Road.',
                'category' => 'Property',
                'subcategory' => 'Apartments',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Bandra',
                'price' => 8500000,
            ],
            [
                'type' => 'product',
                'title' => '3 BHK Villa in Whitefield',
                'description' => 'Beautiful 3 BHK independent villa in gated community. 2400 sq ft built-up area. Modern architecture with garden and parking. Close to ITPL and schools. Ready to move in.',
                'category' => 'Property',
                'subcategory' => 'Houses & Villas',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'Whitefield',
                'price' => 15000000,
            ],
            // Fashion
            [
                'type' => 'product',
                'title' => 'Lehenga Choli - Designer Bridal Collection',
                'description' => 'Gorgeous designer lehenga choli in maroon and gold. Heavy embroidery work with sequins and zari. Worn only once for a wedding reception. Includes matching dupatta. Perfect for weddings and festive occasions.',
                'category' => 'Fashion',
                'subcategory' => 'Women\'s Fashion',
                'state' => 'Delhi',
                'city' => 'New Delhi',
                'area' => 'Karol Bagh',
                'price' => 15000,
            ],
            // Jobs
            [
                'type' => 'service',
                'title' => 'Senior React Developer - Remote',
                'description' => 'Hiring experienced React.js developers for a well-funded startup. 3+ years experience required. Skills: React, Redux, TypeScript, Node.js. Competitive salary + ESOP. Work from home with flexible hours.',
                'category' => 'Jobs',
                'subcategory' => 'IT & Software',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'HSR Layout',
                'price' => 2500000,
            ],
            // Services
            [
                'type' => 'service',
                'title' => 'Professional Home Deep Cleaning Service',
                'description' => 'Complete home deep cleaning service. We cover kitchen, bathrooms, bedrooms, and living areas. Eco-friendly products used. Trained and verified staff. Available on weekends too. Serving all areas of Hyderabad.',
                'category' => 'Services',
                'subcategory' => 'Cleaning',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'Madhapur',
                'price' => 2500,
            ],
            // Furniture
            [
                'type' => 'product',
                'title' => 'L-Shaped Sectional Sofa - Premium Fabric',
                'description' => '7-seater L-shaped sectional sofa in premium grey fabric. Solid wood frame, high-density foam cushions. Bought 6 months ago from Pepperfry. Moving out, hence selling at a great price. Pet-free, smoke-free home.',
                'category' => 'Furniture',
                'subcategory' => 'Sofas',
                'state' => 'Tamil Nadu',
                'city' => 'Chennai',
                'area' => 'Anna Nagar',
                'price' => 35000,
            ],
            [
                'type' => 'product',
                'title' => 'Ergonomic Office Chair - Mesh Back',
                'description' => 'Green Soul Jupiter Superb office chair. Ergonomic mesh back with lumbar support. Adjustable armrests and headrest. Tilt mechanism with tension adjustment. Perfect for long working hours.',
                'category' => 'Furniture',
                'subcategory' => 'Chairs',
                'state' => 'Uttar Pradesh',
                'city' => 'Noida',
                'area' => 'Sector 62',
                'price' => 12000,
            ],
            // Pets
            [
                'type' => 'product',
                'title' => 'Golden Retriever Puppies - KCI Registered',
                'description' => 'Adorable Golden Retriever puppies available. KCI registered, vaccinated, and dewormed. 45 days old. Both parents are show quality. Healthy and playful. Genuine buyers only. Home delivery available.',
                'category' => 'Pets',
                'subcategory' => 'Dogs',
                'state' => 'West Bengal',
                'city' => 'Kolkata',
                'area' => 'Salt Lake',
                'price' => 25000,
            ],
            // More electronics
            [
                'type' => 'product',
                'title' => 'Samsung Galaxy S24 Ultra - 512GB',
                'description' => 'Samsung Galaxy S24 Ultra in Titanium Gray. 512GB storage, 12GB RAM. Comes with Galaxy AI features. S-Pen included. Screen protector and back cover applied since day 1. Bill and warranty card available.',
                'category' => 'Electronics',
                'subcategory' => 'Mobile Phones',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'Jubilee Hills',
                'price' => 109999,
            ],
            [
                'type' => 'product',
                'title' => 'PlayStation 5 with 2 Controllers',
                'description' => 'PS5 Disc Edition with 2 DualSense controllers. Includes 3 games: Spider-Man 2, God of War Ragnarok, and FC 24. All in perfect working condition. Selling because upgrading to PS5 Pro.',
                'category' => 'Electronics',
                'subcategory' => 'Gaming Consoles',
                'state' => 'Maharashtra',
                'city' => 'Pune',
                'area' => 'Koregaon Park',
                'price' => 38000,
            ],
            // More services
            [
                'type' => 'service',
                'title' => 'Math & Science Tutor - Class 8-12',
                'description' => 'Experienced tutor with 10+ years of teaching experience. IIT graduate. Specializing in Mathematics, Physics, and Chemistry for classes 8-12 and competitive exam preparation (JEE/NEET). Online and offline sessions available.',
                'category' => 'Services',
                'subcategory' => 'Tutoring',
                'state' => 'Kerala',
                'city' => 'Kochi',
                'area' => 'Kakkanad',
                'price' => 1500,
            ],
            // Property
            [
                'type' => 'product',
                'title' => 'Commercial Plot - 1200 sq ft',
                'description' => 'Prime commercial plot near main road in Gomti Nagar. 1200 sq ft, clear title. Ideal for showroom, office, or clinic. All utilities available. Excellent connectivity and high footfall area.',
                'category' => 'Property',
                'subcategory' => 'Land & Plots',
                'state' => 'Uttar Pradesh',
                'city' => 'Lucknow',
                'area' => 'Gomti Nagar',
                'price' => 4800000,
            ],
            // Vehicles
            [
                'type' => 'product',
                'title' => 'Honda Activa 6G - 2023',
                'description' => 'Honda Activa 6G in Pearl Precious White color. 2023 model, only 3000 km driven. First owner. All documents clear. Insurance valid. Service history available. Very well maintained.',
                'category' => 'Vehicles',
                'subcategory' => 'Scooters',
                'state' => 'Tamil Nadu',
                'city' => 'Chennai',
                'area' => 'Velachery',
                'price' => 68000,
            ],
            [
                'type' => 'product',
                'title' => 'Canon EOS R6 Mark II - Full Frame Mirrorless',
                'description' => 'Canon EOS R6 Mark II body only. 24.2MP full-frame CMOS sensor. 4K 60fps video. In-body image stabilization. Shutter count under 5000. Includes extra battery, memory card, and camera bag.',
                'category' => 'Electronics',
                'subcategory' => 'Cameras',
                'state' => 'Gujarat',
                'city' => 'Surat',
                'area' => 'Vesu',
                'price' => 185000,
            ],
            [
                'type' => 'product',
                'title' => 'King Size Bed with Storage - Sheesham Wood',
                'description' => 'Solid Sheesham wood king size bed with hydraulic storage. Honey finish. Mattress included (Sleepwell Ortho). 2 years old, excellent condition. Dismantlable for easy transport.',
                'category' => 'Furniture',
                'subcategory' => 'Beds',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'area' => 'Malviya Nagar',
                'price' => 28000,
            ],
        ];

        foreach ($demoListings as $index => $listingData) {
            $category = Category::where('name', $listingData['category'])->whereNull('parent_id')->first();
            $subcategory = Category::where('name', $listingData['subcategory'])->where('parent_id', $category->id)->first();
            $state = Location::where('name', $listingData['state'])->where('type', 'state')->first();
            $city = Location::where('name', $listingData['city'])->where('type', 'city')->where('parent_id', $state->id)->first();
            $area = Location::where('name', $listingData['area'])->where('type', 'area')->where('parent_id', $city->id)->first();

            Listing::create([
                'user_id' => $users[$index % count($users)]->id,
                'type' => $listingData['type'],
                'slug' => strtolower($listingData['title']),
                'title' => $listingData['title'],
                'description' => $listingData['description'],
                'category_id' => $category->id,
                'subcategory_id' => $subcategory?->id,
                'country_id' => $india->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'area_id' => $area?->id,
                'price' => $listingData['price'],
                'currency' => 'INR',
                'status' => 'active',
                'created_at' => now()->subHours(rand(1, 72)),
            ]);
        }
    }
}
