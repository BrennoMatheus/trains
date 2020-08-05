<?php

namespace App\Domain\Entites;

class Route
{
    private string $destination_town;
    private int $distance;

    public function __construct(string $destination_town, int $distance)
    {
        $this->destination_town = $destination_town;
        $this->distance = $distance;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getDestinationTown(): string
    {
        return $this->destination_town;
    }
}
