<?php

namespace App\Domain\Usecases;

use App\Domain\Entites\Routes;

interface DijkstraInterface
{
    public function search(Routes $routes, string $start, string $end): ?int;
}
