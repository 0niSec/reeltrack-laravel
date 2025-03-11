<?php

namespace App\DataTransferObjects;

class MovieDetailsDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $overview,
        public readonly ?int $budget,
        public readonly ?int $revenue,
        public readonly ?string $original_title,
        public readonly ?string $original_language,
        public readonly ?string $status,
        public readonly ?string $poster_path,
        public readonly ?string $backdrop_path,
        public readonly string $release_date,
        public readonly int $runtime,
        public readonly ?string $tagline,
        public readonly array $genres
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
