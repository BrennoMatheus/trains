<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface GetDistanceOfRoutesInterface
{
    public function getDistance(Routes $routes, array $towns): ?int;
}
