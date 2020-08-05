<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\CountTripsByStopsInterface;

class CountTripsByStops implements CountTripsByStopsInterface
{
    public function count(Routes $routes, string $start, string $end, int $number_of_stops): int
    {
        $result = 0;
        $this->searchRoutesWithAnNumberOfStops($routes, $start, $end, $number_of_stops, 0, $result);
        return $result;
    }

    function searchRoutesWithAnNumberOfStops(Routes $routes, string $start, string $end, int $number_of_stops, int $stops, int &$trips): void
    {
        if ($start === $end and $stops === $number_of_stops) {
            $trips++;
            return;
        }

        if ($stops === $number_of_stops) return;

        $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

        foreach ($adjacent_routes as $townName => $route) {
            $nextStop = $stops + 1;
            $this->searchRoutesWithAnNumberOfStops($routes, $townName, $end,  $number_of_stops, $nextStop, $trips);
        }
    }
}
