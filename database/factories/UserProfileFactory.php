<?php

namespace Database\Factories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition(): array
    {
        return [
            'avatar' => null,
            'about' => $this->faker->word(),
            'favorite_movies' => null,
            'favorite_shows' => null,
            'favorite_actors' => null,
            'rated_items' => null,
            'reviewed_items' => null,
            'liked_items' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => 1, // Tie this to the one user we're creating
        ];
    }
}
