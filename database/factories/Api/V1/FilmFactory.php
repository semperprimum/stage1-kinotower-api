<?php

namespace Database\Factories\Api\V1;

use App\Models\Api\V1\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => ucwords($this->faker->unique()->word()),
            "country_id" => Country::factory(),
            "duration" => $this->faker->numberBetween(60, 180),
            "year" => $this->faker->year(),
            "age" => $this->faker->randomElement([3, 7, 12, 16, 18]),
            "link_img" => null,
            "link_kinopoisk" => null,
            "link_video" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
        ];
    }
}
