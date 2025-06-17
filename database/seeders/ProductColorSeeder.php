<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get();

        foreach ($products as $product){
            $colorIds = Color::inRandomOrder()->take(20)->pluck('id')->toArray();
            $product->colors()->sync($colorIds);
        }
    }
}
