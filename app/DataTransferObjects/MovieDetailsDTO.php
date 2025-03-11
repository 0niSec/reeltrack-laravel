<?php

namespace App\DataTransferObjects;

readonly class MovieDetailsDTO
{
    public function __construct(
        public string $id,
        public string $title,
        public string $overview,
        public ?int $budget,
        public ?int $revenue,
        public ?string $original_title,
        public ?string $original_language,
        public ?string $status,
        public ?string $poster_path,
        public ?string $backdrop_path,
        public string $release_date,
        public int $runtime,
        public ?string $tagline,
        public array $genres
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            title: $data['title'],
            overview: $data['overview'],
            budget: $data['budget'],
            revenue: $data['revenue'],
            original_title: $data['original_title'],
            original_language: $data['original_language'],
            status: $data['status'],
            poster_path: $data['poster_path'],
            backdrop_path: $data['backdrop_path'],
            release_date: $data['release_date'],
            runtime: $data['runtime'],
            tagline: $data['tagline'],
            genres: $data['genres']
        );
    }
}
