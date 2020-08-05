<?php

namespace App\Domain\Entites;

class Routes
{
    private array $towns;

    public function __construct()
    {
        $this->towns = [
            'A' => new Town('A'),
            'B' => new Town('B'),
            'C' => new Town('C'),
            'D' => new Town('D'),
            'E' => new Town('E')
        ];
    }

    public function addTown(Town $town): void
    {
        $this->towns[] = $town;
    }

    public function getTowns(): array
    {
        return $this->towns;
    }

    public function getTownByName(string $name): Town
    {
        return $this->towns[$name];
    }

    public function makeRoutes(array $inputs): void
    {
        foreach ($inputs as $input) {
            $start = substr($input, 0, 1);
            $end = substr($input, 1, 1);
            $distance = substr($input, 2);
            $this->towns[$start]->addRoute(new Route($end, $distance));
        }
    }
}
