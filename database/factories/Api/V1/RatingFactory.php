<?php

namespace Database\Factories\Api\V1;

use App\Models\Api\V1\Film;
use App\Models\Api\V1\Rating;
use App\Models\Api\V1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        $filmIds = Film::pluck('id')->toArray();

        return [
            'film_id' => $this->faker->randomElement($filmIds),
            'user_id' => $this->faker->randomElement($userIds),
            'ball' => $this->faker->numberBetween(1, 5),
        ];
    }
}
