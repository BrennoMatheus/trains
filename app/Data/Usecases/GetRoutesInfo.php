<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\GetRoutesInfoInterface;

class GetRoutesInfo implements GetRoutesInfoInterface
{
    private Routes $routes;

    public function __construct(Routes $routes)
    {
        $this->routes = $routes;
    }

    public function getInfo(array $input): array
    {
        $this->routes->makeRoutes($input);

        return [
            $this->routes->getDistance(['A', 'B', 'C']),
            $this->routes->getDistance(['A', 'D']),
            $this->routes->getDistance(['A', 'D', 'C']),
            $this->routes->getDistance(['A', 'E', 'B', 'C', 'D']),
            $this->routes->getDistance(['A', 'E', 'D']),
            $this->routes->countTripsByMaxStops('C', 'C', 3),
            $this->routes->countTripsByStops('A', 'C', 4),
            $this->routes->getLengthOfShortestRouteByDijkstra('A', 'C'),
            $this->routes->getLengthOfShortestRoute('B', 'B'),
            $this->routes->countTripsByMaxLength('C', 'C', 30)
        ];
    }
}
