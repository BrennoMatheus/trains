<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\CountTripsByMaxLengthInterface;

class CountTripsByMaxLength implements CountTripsByMaxLengthInterface
{
    public function count(Routes $routes, string $start, string $end, int $max): int
    {
        $result = 0;
        $visited = [];
        $this->searchRoutesWithMaxLength($routes, $start, $end, 0, $max, 0, $result, $visited);

        return $result;
    }

    private function searchRoutesWithMaxLength(Routes $routes, string $start, string $end, int $length, int $max_length, int $stops, int &$trips): void
    {
        if ($start === $end and $stops !== 0)
            $trips++;

        $adjacent_routes  = $routes->getTownByName($start)->getRoutes();

        foreach ($adjacent_routes as $townName => $route) {

            $nextStop = $stops + 1;
            $distance = $length + $route->getDistance();

            if ($distance >= $max_length) return;

            $this->searchRoutesWithMaxLength($routes, $townName, $end,  $distance, $max_length, $nextStop, $trips);
        }
    }
}
