<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            "status" => [
                "name" => "Processing",
                "color" =>"blue",
                "email_template" => 'Your package is currently being processed'
            ],
            [
             "name" => "Shipped",
             "color" =>"orange",
             "email_template" => "Your package has been shipped"
            ],
            [
            "name" => "Delivered",
            "color" =>"green",
            "email_template" => "Your package has been delivered successfully"
            ],
            [
            "name" => "In Transit",
            "color" =>"orange",
            "email_template" => "Your package is currently in transit"
            ],
            [
            "name" => "Unknown",
            "color" =>"red",
            "email_template" => "Your package status has been updated"
            ],
            [
            "name" => "Delivery Error",
            "color" =>"red",
            "email_template" => "Your package status has been updated"
            ]
        ];
        Status::truncate();
        foreach($statuses as $status){
            Status::create([
             "status"=> $status['name'],
             "color"=> $status['color'],
             "email_template" => $status['email_template']
            ]);
        }

    }
}