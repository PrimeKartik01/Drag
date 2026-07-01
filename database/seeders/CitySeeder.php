<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            'Delhi',
            'Mumbai',
            'Bangalore',
            'Hyderabad',
            'Ahmedabad',
            'Chennai',
            'Kolkata',
            'Surat',
            'Pune',
            'Jaipur',
            'Lucknow',
            'Kanpur',
            'Nagpur',
            'Indore',
            'Bhopal',
            'Patna',
            'Noida',
            'Gurgaon',
            'Ghaziabad',
            'Faridabad',
            'Agra',
            'Varanasi',
            'Chandigarh',
            'Dehradun',
            'Udaipur',
            'Jodhpur',
            'Kota',
            'Amritsar',
            'Ludhiana',
            'Ranchi',
            'Bhubaneswar',
            'Raipur',
            'Coimbatore',
            'Madurai',
            'Kochi',
            'Mysore',
            'Mangalore',
            'Vijayawada',
            'Guntur',
            'Warangal',
            'Visakhapatnam',
            'Nashik',
            'Rajkot',
            'Vadodara',
            'Jamnagar',
            'Bhavnagar',
            'Srinagar',
            'Shimla',
            'Haridwar',
            'Goa',
            'Puducherry',
            'Guwahati',
            'Shillong',
            'Imphal',
            'Agartala',
            'Gangtok'
        ];


        $data = collect($cities)->map(function ($city) {

            return [
                'name' => $city,
                'slug' => Str::slug($city),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];

        })->toArray();


        City::insert($data);
    }
}