<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
                'email' => 'test@example.com',
                'username' => 'MrJohnWick',
                'password' => bcrypt('password'),
            ]
        );

        UserProfile::factory()->create();

        // Seed with some movies
        $this->call([
            MovieSeeder::class,
        ]);
    }
}
