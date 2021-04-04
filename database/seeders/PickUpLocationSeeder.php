<?php

namespace Database\Seeders;

use App\Models\PickUpLocation;
use Illuminate\Database\Seeder;

class PickUpLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PickUpLocation::truncate();
        $locations = [
           "Polaris Dispatch Mandeville, Manchester",
           "Polaris Dispatch Kingston 10, Kingston",
        ];
        foreach($locations as $location){
            PickUpLocation::create([
                'location' => $location
            ]);
        }
    }
}
