<?php

namespace Database\Seeders;

use App\Models\UsAddress;
use Illuminate\Database\Seeder;

class USAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [
            [
                "city" => "Tampa",
                "address_line" => "2236  Taylor Street",
                "state" => "New York",
                "zip_code" => "10013"
            ],
            [
                "city" => "Bedford ",
                "address_line" => "2176  Hummingbird Way",
                "state" => "Massachusetts",
                "zip_code" => "01730"
            ],
            [
                "city" => "Tampa",
                "address_line" => "3725 Marion Drive",
                "state" => "Florida",
                "zip_code" => "33624"
            ]
        ];
        UsAddress::truncate();
        foreach($addresses as $address){
            UsAddress::create([
           "city" => $address['city'],
            "address_line" => $address['address_line'],
            "state" =>  $address['state'],
            "zip_code" => $address['zip_code']
            ]);
        }
    }
}
