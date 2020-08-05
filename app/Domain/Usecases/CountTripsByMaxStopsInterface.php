<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface CountTripsByMaxStopsInterface
{
    public function count(Routes $routes, string $start, string $end, int $max): int;
}
