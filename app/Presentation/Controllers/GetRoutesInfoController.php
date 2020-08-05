<?php

namespace App\Presentation\Controllers;

use App\Domain\Usecases\GetRoutesInfoInterface;
use App\Presentation\Protocols\ControllerInterface;
use App\Presentation\Protocols\RequestInterface;
use App\Presentation\Protocols\Response;
use App\Presentation\Protocols\ResponseInterface;
use App\Presentation\Protocols\ValidatorInterface;
use Exception;

class GetRoutesInfoController implements ControllerInterface
{
    private GetRoutesInfoInterface $getRoutesInfo;
    private ValidatorInterface $validator;


    public function __construct(GetRoutesInfoInterface $getRoutesInfo, ValidatorInterface $validator)
    {
        $this->getRoutesInfo = $getRoutesInfo;
        $this->validator = $validator;
    }
    public function handle(RequestInterface $request): ResponseInterface
    {
        try {
            $routesData = $request->body();

            if (!$this->validator->validate($routesData))
                throw new Exception("Invalid params exception");

            $info = $this->getRoutesInfo->getInfo($routesData);

            return new Response(200, $info);
        } catch (Exception $e) {
            return new Response(500, $e->getMessage());
        }
    }
}
