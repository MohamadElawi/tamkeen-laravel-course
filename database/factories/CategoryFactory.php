<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    use HasFactory;

    protected $model = Category::class;

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


//        $data = [
//            'name' => [
//                'en' => $enFaker->word(),
//                'ar' => $arFaker->word(),
//            ] ,
//            'status' => StatusEnum::ACTIVE
//        ];
//
//        dd($data);

//        dd($cases[rand(0 ,1)]);
        return [
            'name' => [
                'en' => $enFaker->word(),
                'ar' => $arFaker->word(),
            ],
//            'status' => StatusEnum::ACTIVE->value ,
            'status' => $cases[rand(0 ,1)],
            'slug' => $enFaker->slug() ,

        ];
    }


}
