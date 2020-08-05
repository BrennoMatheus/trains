<?php

use App\Data\Usecases\Dijkstra;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class DijkstraTest extends TestCase
{
    private Dijkstra $sut;

    public function setUp(): void
    {
        $this->sut = new Dijkstra();
    }

    public function test_should_calculate_correct_trips_quantity()
    {
        $routes = new Routes();
        $routes->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->search($routes, 'A', 'C');

        $this->assertEquals($result, 9);
    }
}
