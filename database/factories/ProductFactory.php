<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $f = $this->faker;
        return [
            'name' => $f->words(random_int(1, 4), true),
            'price' => random_int(3, 50)*100,
            'image' => $f->imageUrl(),
            'body' => $f->realText(1000),
            'sale' => $f->randomFloat(2, 0, 90),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
