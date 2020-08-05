<?php

use App\Data\Usecases\CountTripsByMaxLength;
use App\Domain\Entites\Routes;
use PHPUnit\Framework\TestCase;


class CountTripsByMaxLengthTest extends TestCase
{
    private CountTripsByMaxLength $sut;

    public function setUp(): void
    {
        $this->sut = new CountTripsByMaxLength();
    }

    public function test_should_calculate_correct_length()
    {
        $routes = new Routes();
        $routes->makeRoutes(["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"]);

        $result = $this->sut->count($routes, 'C', 'C', 30);

        $this->assertEquals($result, 7);
    }
}
