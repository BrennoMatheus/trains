<?php

use App\Data\Usecases\GetRoutesInfo;
use App\Domain\Entites\Route;
use App\Domain\Entites\Routes;
use App\Domain\Usecases\CountTripsByMaxLengthInterface;
use App\Domain\Usecases\CountTripsByMaxStopsInterface;
use App\Domain\Usecases\CountTripsByStopsInterface;
use App\Domain\Usecases\DijkstraInterface;
use App\Domain\Usecases\GetDistanceOfRoutesInterface;
use App\Domain\Usecases\GetLengthOfShortestRouteInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetRoutesInfoTest extends TestCase
{
    private GetRoutesInfo $sut;

    /** @var Routes|MockObject */
    private $routesStub;

    private array $input = ["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"];

    public function setUp(): void
    {
        /** @var Routes|MockObject */
        $this->routesStub = $this->createMock(Routes::class);

        $this->sut = new GetRoutesInfo($this->routesStub);
    }

    public function test_should_calls_make_routes_with_correct_value()
    {
        $this->routesStub
            ->expects($this->at(0))
            ->method('makeRoutes')
            ->with($this->input);

        $this->sut->getInfo($this->input);
    }

    public function test_should_throw_if_make_routes_throws()
    {
        $this->expectException('exception');

        $this->routesStub
            ->method('makeRoutes')
            ->willThrowException(new \Exception('exception'));

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_get_distance_5_times_with_correct_values()
    {
        $this->routesStub->expects($this->at(1))->method('getDistance')->with(['A', 'B', 'C']);
        $this->routesStub->expects($this->at(2))->method('getDistance')->with(['A', 'D']);
        $this->routesStub->expects($this->at(3))->method('getDistance')->with(['A', 'D', 'C']);
        $this->routesStub->expects($this->at(4))->method('getDistance')->with(['A', 'E', 'B', 'C', 'D']);
        $this->routesStub->expects($this->at(5))->method('getDistance')->with(['A', 'E', 'D']);

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_count_trips_by_max_stops_with_correct_values()
    {
        $this->routesStub
            ->expects($this->at(6))
            ->method('countTripsByMaxStops')
            ->with('C', 'C', 3);

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_count_trips_by_stops_with_correct_values()
    {
        $this->routesStub
            ->expects($this->at(7))
            ->method('countTripsByStops')
            ->with('A', 'C', 4);

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_get_length_of_shortest_route_by_dijkstra_with_correct_values()
    {
        $this->routesStub
            ->expects($this->at(8))
            ->method('getLengthOfShortestRouteByDijkstra')
            ->with('A', 'C');

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_get_length_of_shortest_route_with_correct_values()
    {
        $this->routesStub
            ->expects($this->at(9))
            ->method('getLengthOfShortestRoute')
            ->with('B', 'B');

        $this->sut->getInfo($this->input);
    }

    public function test_should_calls_count_trips_by_max_length_with_correct_values()
    {
        $this->routesStub
            ->expects($this->at(10))
            ->method('countTripsByMaxLength')
            ->with('C', 'C', 30);

        $this->sut->getInfo($this->input);
    }

    public function test_should_return_an_array_with_correct_values_if_succeds()
    {
        $this->routesStub
            ->expects($this->at(1))
            ->method('getDistance')
            ->willReturn(9);

        $this->routesStub
            ->expects($this->at(2))
            ->method('getDistance')
            ->willReturn(5);

        $this->routesStub
            ->expects($this->at(3))
            ->method('getDistance')
            ->willReturn(13);

        $this->routesStub
            ->expects($this->at(4))
            ->method('getDistance')
            ->willReturn(22);

        $this->routesStub
            ->expects($this->at(5))
            ->method('getDistance')
            ->willReturn(null);

        $this->routesStub->method('countTripsByMaxStops')->willReturn(2);
        $this->routesStub->method('countTripsByStops')->willReturn(3);
        $this->routesStub->method('getLengthOfShortestRouteByDijkstra')->willReturn(9);
        $this->routesStub->method('getLengthOfShortestRoute')->willReturn(9);
        $this->routesStub->method('countTripsByMaxLength')->willReturn(7);

        $info = $this->sut->getInfo($this->input);

        $this->assertEquals($info, [9, 5, 13, 22, null, 2, 3, 9, 9, 7]);
    }
}
