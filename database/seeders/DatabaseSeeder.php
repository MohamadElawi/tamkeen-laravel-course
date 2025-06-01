<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory(1)->create();
//
//        Category::factory(10)->create();


//        Product::factory(20)->create()->each(function ($product) {
//            $product->categories()->attach(Category::inRandomOrder()->first());
//        });

//        $this->call(CategorySeeder::class);
        $this->call(AdminSeeder::class);

    }
}
