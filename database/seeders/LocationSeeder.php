<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create India
        $india = Location::create([
            'name' => 'India',
            'slug' => 'india',
            'type' => 'country',
        ]);

        $statesAndCities = [
            'Maharashtra' => [
                'Mumbai' => ['Andheri', 'Bandra', 'Juhu', 'Powai', 'Dadar', 'Worli'],
                'Pune' => ['Koregaon Park', 'Hinjewadi', 'Kharadi', 'Viman Nagar', 'Hadapsar'],
                'Nagpur' => ['Dharampeth', 'Sitabuldi', 'Sadar', 'Civil Lines'],
            ],
            'Delhi' => [
                'New Delhi' => ['Connaught Place', 'Karol Bagh', 'Lajpat Nagar', 'Saket', 'Dwarka', 'Rohini'],
                'South Delhi' => ['Greater Kailash', 'Hauz Khas', 'Malviya Nagar', 'Vasant Kunj'],
                'North Delhi' => ['Model Town', 'Pitampura', 'Shalimar Bagh'],
            ],
            'Karnataka' => [
                'Bengaluru' => ['Koramangala', 'Indiranagar', 'Whitefield', 'HSR Layout', 'Electronic City', 'Marathahalli'],
                'Mysuru' => ['Saraswathipuram', 'Vijayanagar', 'Gokulam'],
            ],
            'Tamil Nadu' => [
                'Chennai' => ['T. Nagar', 'Adyar', 'Anna Nagar', 'Velachery', 'OMR', 'Guindy'],
                'Coimbatore' => ['RS Puram', 'Gandhipuram', 'Peelamedu'],
            ],
            'Telangana' => [
                'Hyderabad' => ['Banjara Hills', 'Jubilee Hills', 'Madhapur', 'Gachibowli', 'Ameerpet', 'Secunderabad'],
            ],
            'Gujarat' => [
                'Ahmedabad' => ['Satellite', 'Navrangpura', 'CG Road', 'SG Highway', 'Prahlad Nagar'],
                'Surat' => ['Adajan', 'Vesu', 'Athwa'],
            ],
            'Rajasthan' => [
                'Jaipur' => ['C-Scheme', 'Malviya Nagar', 'Vaishali Nagar', 'Mansarovar'],
                'Jodhpur' => ['Ratanada', 'Paota', 'Sardarpura'],
            ],
            'West Bengal' => [
                'Kolkata' => ['Park Street', 'Salt Lake', 'New Town', 'Howrah', 'Alipore', 'Ballygunge'],
            ],
            'Uttar Pradesh' => [
                'Lucknow' => ['Hazratganj', 'Gomti Nagar', 'Aliganj', 'Indira Nagar'],
                'Noida' => ['Sector 62', 'Sector 18', 'Sector 50'],
            ],
            'Kerala' => [
                'Kochi' => ['Marine Drive', 'MG Road', 'Edappally', 'Kakkanad'],
                'Thiruvananthapuram' => ['Technopark', 'Kowdiar', 'Vellayambalam'],
            ],
        ];

        foreach ($statesAndCities as $stateName => $cities) {
            $state = Location::create([
                'name' => $stateName,
                'slug' => Str::slug($stateName),
                'type' => 'state',
                'parent_id' => $india->id,
            ]);

            foreach ($cities as $cityName => $areas) {
                $city = Location::create([
                    'name' => $cityName,
                    'slug' => Str::slug($cityName),
                    'type' => 'city',
                    'parent_id' => $state->id,
                ]);

                foreach ($areas as $areaName) {
                    Location::create([
                        'name' => $areaName,
                        'slug' => Str::slug($areaName),
                        'type' => 'area',
                        'parent_id' => $city->id,
                    ]);
                }
            }
        }
    }
}
