<?php

namespace App\Data\Usecases;

use App\Domain\Entites\Routes;
use App\Domain\Usecases\DijkstraInterface;

class Dijkstra implements DijkstraInterface
{
    public function search(Routes $routes, string $start, string $end): ?int
    {
        $unvisited = $routes->getTowns();
        $distance = array_map(fn ($town) => $town->getName() === $start ? 0 : 999999, $unvisited);

        while ($unvisited) {
            $near = $this->closest($unvisited, $distance);

            unset($unvisited[$near]);

            foreach ($routes->getTownByName($near)->getRoutes() as $route) {
                $total_distance = $distance[$near] + $route->getDistance();

                if ($total_distance < $distance[$route->getDestinationTown()])
                    $distance[$route->getDestinationTown()] = $total_distance;
            }

            if ($near == $end)
                return $distance[$end];
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
}
