<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\GetDistanceOfRoutesInterface;

class GetDistanceOfRoutes implements GetDistanceOfRoutesInterface
{
    public function getDistance(Routes $routes, array $towns): ?int
    {
        $distance = 0;

        foreach ($towns as $key => $town) {

            if ($key === array_key_last($towns))
                break;

            $route = $routes
                ->getTowns()[$town]
                ->findRouteByDestination($towns[$key + 1]);

            if (!$route) {
                return null;
            }

            $distance += $route->getDistance();
        }

        return $distance;
    }
}
