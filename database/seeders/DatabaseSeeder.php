<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Api\V1\CategoryFilm;
use App\Models\Api\V1\Gender;
use App\Models\Api\V1\Rating;
use App\Models\Api\V1\Review;
use App\Models\Api\V1\User;
use Database\Factories\Api\V1\ReviewFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Gender::factory()->create([
            "name" => "Мужской"
        ]);
        Gender::factory()->create([
            "name" => "Женский"
        ]);

        User::factory(20)->create();
        CategoryFilm::factory(20)->create();
        Review::factory(40)->create();
        Rating::factory(50)->create();

    }
}
