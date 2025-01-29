<?php

namespace App\Services;

use App\Models\Person;

class PersonService
{
    public function updateOrCreatePerson(array $castData): Person
    {
        return Person::updateOrCreate(
            ['tmdb_id' => $castData['id']],
            $this->mapCastDataToAttributes($castData)
        );
    }

    protected function mapCastDataToAttributes(array $castData): array
    {
        return [
            'name' => $castData['name'],
            'profile_path' => $castData['profile_path'] ?? null,
            'gender' => $castData['gender'] ?? 0,
            'birthday' => $castData['birthday'] ?? null,
            'deathday' => $castData['deathday'] ?? null,
            'place_of_birth' => $castData['place_of_birth'] ?? null,
            'biography' => $castData['biography'] ?? null,
        ];
    }
}
