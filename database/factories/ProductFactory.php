<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'images' => implode(',', $this->faker->randomElements([$this->faker->imageUrl(224, 224, 'products'), $this->faker->imageUrl(224, 224, 'products'), $this->faker->imageUrl(224, 224, 'products')], 3)),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'description' => $this->faker->paragraph,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->category_id,
        ];
    }
}
