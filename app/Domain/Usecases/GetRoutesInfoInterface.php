<?php

namespace App\Domain\Usecases;

interface GetRoutesInfoInterface
{
    public function getInfo(array $input): array;
}
