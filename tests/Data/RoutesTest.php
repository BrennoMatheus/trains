<?php

use App\Data\Usecases\CountTripsByMaxStops;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class RoutesTest extends TestCase
{
    private Routes $sut;

    public function setUp(): void
    {
        $this->sut = new Routes();
    }

    public function test_should_calculate_correct_distances()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result1 = $this->sut->getDistance(['A', 'B', 'C']);
        $result2 = $this->sut->getDistance(['A', 'D']);
        $result3 = $this->sut->getDistance(['A', 'D', 'C']);
        $result4 = $this->sut->getDistance(['A', 'E', 'B', 'C', 'D']);
        $result5 = $this->sut->getDistance(['A', 'E', 'D']);


        $this->assertEquals($result1, 9);
        $this->assertEquals($result2, 5);
        $this->assertEquals($result3, 13);
        $this->assertEquals($result4, 22);
        $this->assertEquals($result5, null);
    }

    public function test_should_calculate_correct_trips_quantity_by_max_stops()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $trips = $this->sut->countTripsByMaxStops('C', 'C', 3);

        $this->assertEquals($trips, 2);
    }

    public function test_should_calculate_correct_trips_quantity_by_max_length()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->countTripsByMaxLength('C', 'C', 30);

        $this->assertEquals($result, 7);
    }

    public function test_should_calculate_correct_trips_quantity_by_stops()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->countTripsByStops('A', 'C', 4);

        $this->assertEquals($result, 3);
    }

    public function test_should_calculate_correct_length_by_dijkstra()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->getLengthOfShortestRouteByDijkstra('A', 'C');

        $this->assertEquals($result, 9);
    }

    public function test_should_calculate_correct_trips_quantity()
    {
        $this->sut->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->getLengthOfShortestRoute('B', 'B');

        $this->assertEquals($result, 9);
    }
}
