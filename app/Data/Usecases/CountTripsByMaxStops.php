<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\CountTripsByMaxStopsInterface;

class CountTripsByMaxStops implements CountTripsByMaxStopsInterface
{
    public function count(Routes $routes, string $start, string $end, int $max): int
    {
        $result = 0;
        $this->searchRoutesWithMaxStops($routes, $start, $end, $max, 0, $result);
        return $result;
    }

    function searchRoutesWithMaxStops(Routes $routes, string $start, string $end, int $max, int $stops, int &$trips): void
    {
        if ($start === $end and $stops !== 0) {
            $trips++;
            return;
        }

        if ($stops === $max) return;

        $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

        foreach ($adjacent_routes as $townName => $route) {
            $nextStop = $stops + 1;
            $this->searchRoutesWithMaxStops($routes, $townName, $end,  $max, $nextStop, $trips);
        }
    }
}
