<?php

use App\Data\Usecases\GetDistanceOfRoutes;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class GetDistanceOfRoutesTest extends TestCase
{
    private GetDistanceOfRoutes $sut;

    public function setUp(): void
    {
        $this->sut = new GetDistanceOfRoutes();
    }

    public function test_should_calculate_correct_distances()
    {
        $routes = new Routes();
        $routes->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);


        $result1 = $this->sut->getDistance($routes, ['A', 'B', 'C']);
        $result2 = $this->sut->getDistance($routes, ['A', 'D']);
        $result3 = $this->sut->getDistance($routes, ['A', 'D', 'C']);
        $result4 = $this->sut->getDistance($routes, ['A', 'E', 'B', 'C', 'D']);
        $result5 = $this->sut->getDistance($routes, ['A', 'E', 'D']);


        $this->assertEquals($result1, 9);
        $this->assertEquals($result2, 5);
        $this->assertEquals($result3, 13);
        $this->assertEquals($result4, 22);
        $this->assertEquals($result5, null);
    }
}
