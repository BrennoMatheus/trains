<?php

use App\Data\Usecases\CountTripsByMaxStops;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class CountTripsByMaxStopsTest extends TestCase
{
    private CountTripsByMaxStops $sut;

    public function setUp(): void
    {
        $this->sut = new CountTripsByMaxStops();
    }

    public function test_should_calculate_correct_trips_quantity()
    {
        $routes = new Routes();
        $routes->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->count($routes, 'C', 'C', 3);

        $this->assertEquals($result, 2);
    }
}
