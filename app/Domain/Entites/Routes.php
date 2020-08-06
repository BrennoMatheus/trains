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

    public function makeRoutes(array $inputs): Routes
    {
        foreach ($inputs as $input) {
            $start = substr($input, 0, 1);
            $end = substr($input, 1, 1);
            $distance = substr($input, 2);

            if (!$this->towns[$start]->findRouteByDestination($end))
                $this->towns[$start]->addRoute(new Route($end, $distance));
        }

        return $this;
    }

    public function getDistance(array $towns): ?int
    {
        $distance = 0;

        foreach ($towns as $key => $town) {

            if ($key === array_key_last($towns)) break;

            $route = $this->towns[$town]->findRouteByDestination($towns[$key + 1]);

            if (!$route) return null;

            $distance += $route->getDistance();
        }

        return $distance;
    }

    public function countTripsByMaxStops(string $start, string $end, int $max): int
    {
        $result = 0;
        $this->searchRoutesWithMaxStops($start, $end, $max, 0, $result);
        return $result;
    }

    private function searchRoutesWithMaxStops(string $start, string $end, int $max, int $stops, int &$trips): void
    {
        if ($start === $end and $stops !== 0) {
            $trips++;
            return;
        }

        if ($stops === $max) return;

        $adjacent_routes  = $this->towns[$start]->getRoutes();

        if (!$adjacent_routes) return;

        foreach ($adjacent_routes as $townName => $route) {
            $nextStop = $stops + 1;
            $this->searchRoutesWithMaxStops($townName, $end,  $max, $nextStop, $trips);
        }
    }

    public function countTripsByMaxLength(string $start, string $end, int $max): int
    {
        $result = 0;
        $visited = [];
        $this->searchRoutesWithMaxLength($start, $end, 0, $max, 0, $result, $visited);

        return $result;
    }

    private function searchRoutesWithMaxLength(string $start, string $end, int $length, int $max_length, int $stops, int &$trips): void
    {
        if ($start === $end and $stops !== 0)
            $trips++;

        $adjacent_routes  = $this->towns[$start]->getRoutes();

        if (!$adjacent_routes) return;

        foreach ($adjacent_routes as $townName => $route) {

            $nextStop = $stops + 1;
            $distance = $length + $route->getDistance();

            if ($distance >= $max_length) return;

            $this->searchRoutesWithMaxLength($townName, $end,  $distance, $max_length, $nextStop, $trips);
        }
    }

    public function countTripsByStops(string $start, string $end, int $number_of_stops): int
    {
        $result = 0;
        $this->searchRoutesWithAnNumberOfStops($start, $end, $number_of_stops, 0, $result);
        return $result;
    }

    private function searchRoutesWithAnNumberOfStops(string $start, string $end, int $number_of_stops, int $stops, int &$trips): void
    {
        if ($start === $end and $stops === $number_of_stops) {
            $trips++;
            return;
        }

        if ($stops === $number_of_stops) return;

        $adjacent_routes  = $this->towns[$start]->getRoutes();

        if (!$adjacent_routes) return;

        foreach ($adjacent_routes as $townName => $route) {
            $nextStop = $stops + 1;
            $this->searchRoutesWithAnNumberOfStops($townName, $end,  $number_of_stops, $nextStop, $trips);
        }
    }

    public function getLengthOfShortestRouteByDijkstra(string $start, string $end): ?int
    {
        $unvisited = $this->towns;
        $distance = array_map(fn ($town) => $town->getName() === $start ? 0 : 999999, $unvisited);

        while ($unvisited) {
            $near = $this->closest($unvisited, $distance);

            unset($unvisited[$near]);

            $routes = $this->towns[$near]->getRoutes();

            if ($routes) {
                foreach ($routes as $route) {
                    $total_distance = $distance[$near] + $route->getDistance();

                    if ($total_distance < $distance[$route->getDestinationTown()])
                        $distance[$route->getDestinationTown()] = $total_distance;
                }
            }

            if ($near === $end) return $distance[$end];
        }

        return null;
    }

    private function closest(array $unvisited, array $distance): string
    {
        $diff = array_diff_key($distance, $unvisited);
        $tmp = $distance;

        foreach ($diff as $name => $town) unset($tmp[$name]);

        return array_search(min($tmp), $tmp);
    }

    public function getLengthOfShortestRoute(string $start, string $end): ?int
    {
        $result = [];
        $visited = [];
        $this->searchRoutes($start, $end, 0, 0, $result, $visited);

        return !$result ? null : min($result);
    }

    private function searchRoutes(string $start, string $end, int $length, int $stops, array &$trips, array $visited): void
    {
        $visited[] = $start;

        if ($start === $end and $stops !== 0) {
            $trips[] = $length;
            return;
        }

        $adjacent_routes  = $this->towns[$start]->getRoutes();

        if (!$adjacent_routes) return;

        foreach ($adjacent_routes as $townName => $route) {
            if (!array_search($townName, $visited) or $townName === $end) {
                $nextStop = $stops + 1;
                $distance = $length + $route->getDistance();
                $this->searchRoutes($townName, $end,  $distance, $nextStop, $trips, $visited);
            }
        }
    }
}
