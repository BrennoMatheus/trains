<?php

use App\Domain\Usecases\GetRoutesInfoInterface;
use App\Presentation\Controllers\GetRoutesInfoController;
use App\Presentation\Protocols\Request;
use App\Presentation\Protocols\ValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class GetRoutesInfoControllerTest extends TestCase
{
    private GetRoutesInfoController $sut;

    /** @var ValidatorInterface|MockObject */
    private $validatorStub;

    /** @var GetRoutesInfoInterface|MockObject */
    private $getRoutesInfoStub;

    public function setUp(): void
    {
        /** @var ValidatorInterface|MockObject */
        $this->validatorStub = $this->createMock(ValidatorInterface::class);

        /** @var GetRoutesInfoInterface|MockObject */
        $this->getRoutesInfoStub = $this->createMock(GetRoutesInfoInterface::class);

        $this->sut = new GetRoutesInfoController($this->getRoutesInfoStub, $this->validatorStub);
    }

    private function makeData()
    {
        return ["AB5", "BC4", "CD8", "DC8", "DE6", "AD5", "CE2", "EB3", "AE7"];
    }

    public function test_should_call_validator_with_correct_values()
    {
        $data = $this->makeData([]);

        $this->validatorStub
            ->expects($this->once())
            ->method('validate')
            ->with($data);

        $this->sut->handle(new Request($data));
    }

    public function test_should_return_an_invalid_param_exception_if_validation_fails()
    {
        $data = $this->makeData([]);

        $this->validatorStub
            ->method('validate')
            ->willReturn(false);

        $response = $this->sut->handle(new Request($data));

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals($response->getBody(), 'Invalid params exception');
    }

    public function test_should_call_get_routes_info_with_correct_values()
    {
        $data = $this->makeData([]);

        $this->validatorStub
            ->method('validate')
            ->willReturn(true);

        $this->getRoutesInfoStub
            ->expects($this->once())
            ->method('getInfo')
            ->with($data);

        $this->sut->handle(new Request($data));
    }

    public function test_should_return_500_if_get_routes_info_throws()
    {
        $data = $this->makeData([]);

        $this->validatorStub
            ->method('validate')
            ->willReturn(true);

        $this->getRoutesInfoStub
            ->method('getInfo')
            ->willThrowException(new Exception('Server error'));

        $response = $this->sut->handle(new Request($data));

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals($response->getBody(), 'Server error');
    }

    public function test_should_return_200_if_succeds()
    {
        $data = $this->makeData([]);
        $responseData = [9, 5, 13, 22, null, 2, 3, 9, 9, 7];

        $this->validatorStub
            ->method('validate')
            ->willReturn(true);

        $this->getRoutesInfoStub
            ->method('getInfo')
            ->willReturn($responseData);

        $response = $this->sut->handle(new Request($data));

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getBody(), $responseData);
    }
}
