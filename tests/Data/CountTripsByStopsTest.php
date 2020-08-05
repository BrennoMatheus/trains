<?php

use App\Data\Usecases\CountTripsByStops;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class CountTripsByStopsTest extends TestCase
{
    private CountTripsByStops $sut;

    public function setUp(): void
    {
        $this->sut = new CountTripsByStops();
    }

    public function test_should_calculate_correct_trips_quantity()
    {
        $routes = new Routes();
        $routes->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->count($routes, 'A', 'C', 4);

        $this->assertEquals($result, 3);
    }
}
