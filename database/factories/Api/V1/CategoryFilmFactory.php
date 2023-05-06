<?php

namespace Database\Factories\Api\V1;

use App\Models\Api\V1\Category;
use App\Models\Api\V1\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "category_id" => Category::factory(),
            "film_id" => Film::factory()
        ];
    }
}
