<?php

namespace App\Contracts;

interface Watchable
{
    public function getTitle(): string;

    /**
     * Get the unique identifier of the watchable item.
     *
     * @return int|string The ID of the watchable item
     */
    public function getId(): int|string;
}
