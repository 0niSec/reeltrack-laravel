<?php

namespace App\Services;

use App\Models\Person;

class PersonService
{
    private TmdbApiService $tmdb; // FIXME: Is there a better way than to pass another TmdbApiService here?

    public function __construct()
    {
        $this->tmdb = new TmdbApiService();
    }

    public function updateOrCreatePerson(array $castData): Person
    {
        return Person::updateOrCreate(
            ['tmdb_id' => $castData['id']],
            $this->mapCastDataToAttributes($castData)
        );
    }

    protected function mapCastDataToAttributes(array $castData): array
    {
        $personDetails = $this->tmdb->personDetails($castData['id']);

        return [
            'name' => $personDetails['name'],
            'profile_path' => 'https://image.tmdb.org/t/p/original'.$personDetails['profile_path'] ?? null,
            'gender' => $personDetails['gender'] ?? 0,
            'birthday' => $personDetails['birthday'] ?? null,
            'deathday' => $personDetails['deathday'] ?? null,
            'place_of_birth' => $personDetails['place_of_birth'] ?? null,
            'biography' => $personDetails['biography'] ?? null,
        ];
    }
}
