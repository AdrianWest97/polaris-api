<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
    $data = json_decode(file_get_contents(public_path('demo.json')),true);
    foreach($data as $item){
       Product::create([
            'name' => $item['title'],
            'caption' => $item['title'],
            'description' => $item['description'],
            'price' => $item['price'],
            'category_id' => 9 ,
            'use_url' => true,
            'image_url' => $item['thumbnail_url'],
            'stock' => $item['quantity'],
            'visible' => true,
            'tags' => 'electronic,macbook,apple',
       ]);
    }
    }
}