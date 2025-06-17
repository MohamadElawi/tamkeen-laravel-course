<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    use HasFactory;
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enFaker = fake('en_US');

        $arFaker = fake('ar_SA');
        $cases = StatusEnum::cases();
        return [
            'name' => [
                'en' => $enFaker->words(2, true),
                'ar' => $arFaker->words(2, true),
            ],
            'description' => [
                'en' => $enFaker->sentence(),
                'ar' => $arFaker->sentence(),
            ],
            'price' => $enFaker->randomFloat(2, 100, 100000),
            'slug' => $enFaker->unique()->slug(),
            'status' => $cases[array_rand($cases)] ,
            'quantity' => $enFaker->numberBetween( 10, 1000),
        ];
    }
}
