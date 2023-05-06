<?php

namespace Database\Factories\Api\V1;

use App\Models\Api\V1\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parentCategoryIds = Category::pluck('id')->toArray();

        return [
            "name" => ucwords($this->faker->unique()->word()),
            "parent_id" => $this->faker->boolean(50) ? $this->faker->randomElement($parentCategoryIds) : null,
        ];
    }
}
