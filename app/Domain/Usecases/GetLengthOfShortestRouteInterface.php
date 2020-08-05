<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface GetLengthOfShortestRouteInterface
{
    public function getLength(Routes $routes, string $start, string $end): int;
}
