<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class CreditsService
{
    private PersonService $personService;

    public function __construct()
    {
        $this->personService = new PersonService();
    }

    /**
     * Save cast members for the given movie.
     *
     * @param  array  $castMembers
     * @param  Movie  $movie
     * @return void
     */
    public function storeCastMembers(array $castMembers, Movie $movie): void
    {
        DB::transaction(function () use ($castMembers, $movie) {
            foreach ($castMembers as $castMember) {
                // Find or create the person
                $person = $this->personService->updateOrCreatePerson($castMember);

                // Create or update the cast member using polymorphic relation
                $movie->cast()->updateOrCreate(
                    [
                        'person_id' => $person->id,
                        'character' => $castMember['character'] ?? null,
                        'name' => $castMember['name'],
                        'order' => $castMember['order'] ?? null,
                    ]
                );
            }
        });
    }

    /**
     * Store crew members for the provided movie
     * @param  array  $crewMembers
     * @param  Movie  $movie
     * @return void
     */
    public function storeCrewMembers(array $crewMembers, Movie $movie): void
    {
        DB::transaction(function () use ($movie, $crewMembers) {
            foreach ($crewMembers as $crewMember) {
                // Find or create the person
                $person = $this->personService->updateOrCreatePerson($crewMember);

                // Create or update the cast member using polymorphic relation
                $movie->crew()->updateOrCreate(
                    [
                        'person_id' => $person->id,
                        'name' => $crewMember['name'],
                        'job' => $crewMember['job'],
                        'department' => $crewMember['department'],
                    ]
                );
            }
        });
    }
}
