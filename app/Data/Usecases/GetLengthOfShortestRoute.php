<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\GetLengthOfShortestRouteInterface;

class GetLengthOfShortestRoute implements GetLengthOfShortestRouteInterface
{
    public function getLength(Routes $routes, string $start, string $end): int
    {
        $result = [];
        $visited = [];
        $this->searchRoutes($routes, $start, $end, 0, 0, $result, $visited);

        return min($result);
    }

    private function searchRoutes(Routes $routes, string $start, string $end, int $length, int $stops, array &$trips, array $visited): void
    {
        $visited[] = $start;

        if ($start === $end and $stops !== 0) {
            $trips[] = $length;
            return;
        }

        $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

        foreach ($adjacent_routes as $townName => $route) {
            if (!array_search($townName, $visited) or $townName === $end) {
                $nextStop = $stops + 1;
                $distance = $length + $route->getDistance();
                $this->searchRoutes($routes, $townName, $end,  $distance, $nextStop, $trips, $visited);
            }
        }
    }
}
