<?php

namespace App\Main\Factories;

use App\Data\Usecases\GetRoutesInfo;
use App\Domain\Entites\Routes;
use App\Presentation\Controllers\GetRoutesInfoController;
use App\Presentation\Validators\Validator;

class GetRoutesInfoControllerFactory
{
    public function make()
    {
        $getRoutesInfo = new GetRoutesInfo(new Routes());
        $validate = new Validator();
        return new GetRoutesInfoController($getRoutesInfo, $validate);
    }
}
