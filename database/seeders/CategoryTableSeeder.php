<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Apparel",
             "Footwear",
             "Bags",
             "Accessories",
             "Jewelry",
             "Eyewear",
             "Cosmetics",
             "Beauty",
             "Electronics",
             "Gadgets"
        ];

        Category::truncate();
        foreach($categories as $category){
            Category::create([
                "name" => $category
            ]);
        }
    }
}