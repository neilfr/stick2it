<?php

namespace Database\Factories;

use App\Models\Foodgroup;
use App\Models\Foodsource;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'alias' => $this->faker->sentence,
            'kcal' => $this->faker->numberBetween(1, 300),
            'fat' => $this->faker->numberBetween(1, 300),
            'protein' => $this->faker->numberBetween(1, 300),
            'carbohydrate' => $this->faker->numberBetween(1, 300),
            'potassium' => $this->faker->numberBetween(1, 300),
            'base_quantity' => $this->faker->numberBetween(1, 300),
            'foodgroup_id' => Foodgroup::factory()->create()->id,
            'foodsource_id' => Foodsource::factory()->create()->id,
            'user_id' => auth()->user()->id,
        ];
    }
}
