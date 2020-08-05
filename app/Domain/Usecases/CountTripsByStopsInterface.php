<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface CountTripsByStopsInterface
{
    public function count(Routes $routes, string $start, string $end, int $number_of_stops): int;
}
