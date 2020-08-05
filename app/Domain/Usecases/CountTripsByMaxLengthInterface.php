<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface CountTripsByMaxLengthInterface
{
    public function count(Routes $routes, string $start, string $end, int $max): int;
}
