<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Person;
use App\Services\TmdbApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $tmdb = new TmdbApiService();
        $randomIds = [120, 121, 122, 49051, 122917, 57158, 245891, 603692, 324552, 458156];

        foreach ($randomIds as $id) {
            // Fetch the main movie details.
            $movieDetails = $tmdb->movieDetails($id);
            if (!$movieDetails || empty($movieDetails['id'])) {
                continue;
            }

            $slugTitle = preg_replace('/[^A-Za-z0-9\-]/', '-', $movieDetails['title']);

            $movieBackdropUrl = $tmdb->backdropUrl($movieDetails['backdrop_path'] ?? null);
            $backdropLocalPath = null;
            if ($movieBackdropUrl) {
                $imageContents = file_get_contents($movieBackdropUrl);

                $filename = "backdrops/movie_{$id}_{$slugTitle}.jpg";

                Storage::disk('public')->put($filename, $imageContents);

                $backdropLocalPath = Storage::url($filename);
            }

            // Create the Movie record.
            $movie = Movie::create([
                'tmdb_id' => $movieDetails['id'],
                'title' => $movieDetails['title'],
                'overview' => $movieDetails['overview'],
                'tagline' => $movieDetails['tagline'],
                'poster_path' => $tmdb->posterUrl($movieDetails['poster_path'] ?? null),
                'backdrop_path' => $backdropLocalPath,
                'release_date' => $movieDetails['release_date'],
                'runtime' => $movieDetails['runtime'],
            ]);

            foreach ($movieDetails['genres'] as $genre) {
                $movie->genres()->create([
                    'name' => $genre['name'],
                    'tmdb_id' => $genre['id'],
                ]);
            }

            // Fetch credits
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

                $profilePath = null;
                $profileUrl = $tmdb->posterUrl($personDetails['profile_path'] ?? null);

                if ($profileUrl) {
                    $personImageContents = file_get_contents($profileUrl);
                    $profileImagePath = "people/person_{$personDetails['id']}_{$personDetails['name']}.jpg";
                    Storage::disk('public')->put($profileImagePath, $personImageContents);


                    $profilePath = Storage::url($profileImagePath);
                }

                // Create or update the Person record.
                $person = Person::updateOrCreate(
                    ['tmdb_id' => $personDetails['id']],
                    [
                        'name' => $personDetails['name'] ?? null,
                        'biography' => $personDetails['biography'] ?? null,
                        'profile_path' => $profilePath,
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
                        'profile_path' => $tmdb->posterUrl($personDetails['profile_path']),
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
