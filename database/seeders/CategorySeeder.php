<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Category::factory(20)->has(Product::factory(20))->create();
        $categories = [
            ['name' => ['en' => 'Electronics', 'ar' => 'إلكترونيات']],
            ['name' => ['en' => 'Fashion', 'ar' => 'موضة']],
            ['name' => ['en' => 'Home & Kitchen', 'ar' => 'المنزل والمطبخ']],
            ['name' => ['en' => 'Books', 'ar' => 'كتب']],
            ['name' => ['en' => 'Toys', 'ar' => 'ألعاب']],
            ['name' => ['en' => 'Sports', 'ar' => 'رياضة']],
            ['name' => ['en' => 'Beauty', 'ar' => 'جمال']],
            ['name' => ['en' => 'Automotive', 'ar' => 'سيارات']],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => \Str::slug($cat['name']['en']),
                'status' => 'active',
            ]);
        }
    }
}
