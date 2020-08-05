<?php

namespace App\Presentation\Protocols;

interface ValidatorInterface
{
    public function validate(array $data): bool;
}
