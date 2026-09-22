<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $category = Category::query()->inRandomOrder()->first();

        if (! $category) {
            $category = Category::query()->create([
                'name' => 'Umum',
                'slug' => 'umum',
            ]);
        }

        return [
            'category_id' => $category->id,
            'name' => $this->faker->unique()->words(2, true),
            'sku' => 'PRD-' . $this->faker->unique()->numerify('######'),
            'price' => $this->faker->numberBetween(2000, 50000),
            'stock' => $this->faker->numberBetween(5, 100),
        ];
    }
}
