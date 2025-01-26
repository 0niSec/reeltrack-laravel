<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Person;
use App\Services\TmdbService;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $tmdb = new TmdbService();
        $randomIds = collect(range(1, 3991))->random(25);

        foreach ($randomIds as $id) {
            // Fetch the main movie details.
            $movieDetails = $tmdb->movieDetails($id);
            if (!$movieDetails || empty($movieDetails['id'])) {
                continue;
            }

            // Create the Movie record.
            $movie = Movie::create([
                'tmdb_id' => $movieDetails['id'],
                'title' => $movieDetails['title'],
                'overview' => $movieDetails['overview'],
                'tagline' => $movieDetails['tagline'],
                'poster_path' => $tmdb->posterUrl($movieDetails['poster_path'] ?? null),
                'backdrop_path' => $tmdb->backdropUrl($movieDetails['backdrop_path'] ?? null),
                'release_date' => $movieDetails['release_date'],
                'runtime' => $movieDetails['runtime'],
            ]);

            foreach ($movieDetails['genres'] as $genre) {
                $movie->genres()->create([
                    'name' => $genre['name'],
                    'tmdb_id' => $genre['id'],
                ]);
            }

            // Fetch credits.
            $credits = $tmdb->movieCredits($id);
            $castArray = $credits['cast'] ?? [];
            $crewArray = $credits['crew'] ?? [];

            // Handle cast members.
            foreach ($castArray as $member) {
                if (empty($member['id'])) {
                    continue;
                }

                $personDetails = $tmdb->personDetails($member['id']);
                if (!$personDetails || empty($personDetails['id'])) {
                    continue;
                }

                // Create or update the Person record.
                $person = Person::updateOrCreate(
                    ['tmdb_id' => $personDetails['id']],
                    [
                        'name' => $personDetails['name'] ?? null,
                        'biography' => $personDetails['biography'] ?? null,
                        'profile_path' => $tmdb->backdropUrl($personDetails['profile_path'], "original" ?? null),
                        'birthday' => $personDetails['birthday'] ?? null,
                        'deathday' => $personDetails['deathday'] ?? null,
                        'place_of_birth' => $personDetails['place_of_birth'] ?? null,
                        'gender' => $personDetails['gender'] ?? 0,
                    ]
                );

                // Create the cast record, linking via morph relation.
                $movie->cast()->create([
                    'person_id' => $person->id,
                    'name' => $member['name'] ?? null,
                    'character' => $member['character'] ?? null,
                    'order' => $member['order'] ?? 0,
                ]);
            }

            // Handle crew members.
            foreach ($crewArray as $member) {
                if (empty($member['id'])) {
                    continue;
                }

                $personDetails = $tmdb->personDetails($member['id']);
                if (!$personDetails || empty($personDetails['id'])) {
                    continue;
                }

                // Create or update the Person record.
                $person = Person::updateOrCreate(
                    ['tmdb_id' => $personDetails['id']],
                    [
                        'name' => $personDetails['name'] ?? null,
                        'biography' => $personDetails['biography'] ?? null,
                        'profile_path' => $tmdb->backdropUrl($personDetails['profile_path'], "original" ?? null),
                        'birthday' => $personDetails['birthday'] ?? null,
                        'deathday' => $personDetails['deathday'] ?? null,
                        'place_of_birth' => $personDetails['place_of_birth'] ?? null,
                        'gender' => $personDetails['gender'] ?? 0,
                    ]
                );

                // Create the crew record, linking via morph relation.
                $movie->crew()->create([
                    'person_id' => $person->id,
                    'department' => $member['department'] ?? null,
                    'job' => $member['job'] ?? null,
                    'name' => $member['name'] ?? null,
                ]);
            }
        }
    }
}
