<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'fname' => 'Adrian',
            'lname' => 'West',
            'email' => 'admin@test.com',
            'is_admin' => true,
            'password' => Hash::make("password"),
             'id_type' => 'trn',
            'id_number' => "15465933",
            'phone' => '8764849274',
            'us_address_id' => 1,
            'pickup_id' => 1
        ]);
        User::create([
            'fname' => 'Adrian',
            'lname' => 'West',
            'email' => 'west@test.com',
            'password' => Hash::make("password"),
            'id_type' => 'trn',
            'id_number' => "15485933",
            'phone' => '8764849374',
             'us_address_id' => 1,
            'pickup_id' => 1


        ]);
        User::create([
            'fname' => 'Diva',
            'lname' => 'Riley',
            'email' => 'diva@test.com',
            'password' => Hash::make("password"),
            'id_type' => 'trn',
            'id_number' => "55485933",
            'phone' => '8766849374',
             'us_address_id' => 1,
             'pickup_id' => 1

        ]);
        User::create([
            'fname' => 'Sanique',
            'lname' => 'West',
            'email' => 'swest@test.com',
            'password' => Hash::make("password"),
            'id_type' => 'trn',
            'id_number' => "85485933",
            'phone' => '8796849374',
            'us_address_id' => 1,
             'pickup_id' => 1

        ]);
        User::create([
            'fname' => 'Richard',
            'lname' => 'Brown',
            'email' => 'richard@test.com',
            'password' => Hash::make("password"),
            'id_type' => 'trn',
            'id_number' => "55495933",
            'phone' => '8766809374',
            'us_address_id' => 1,
            'pickup_id' => 1
        ]);
    }
}