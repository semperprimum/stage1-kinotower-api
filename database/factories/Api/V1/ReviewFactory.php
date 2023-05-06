<?php

namespace Database\Factories\Api\V1;

use App\Models\Api\V1\CategoryFilm;
use App\Models\Api\V1\Film;
use App\Models\Api\V1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filmIds = Film::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'film_id' => $this->faker->randomElement($filmIds),
            "user_id" => $this->faker->randomElement($userIds),
            "message" => $this->faker->sentence(),
            "is_approved" => $this->faker->boolean()
        ];
    }
}
