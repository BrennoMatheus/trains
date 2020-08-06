<?php

namespace App\Presentation\Validators;

use App\Presentation\Protocols\ValidatorInterface;

class Validator implements ValidatorInterface
{
    public function validate(array $data): bool
    {
        foreach ($data as $input)
            if (!preg_match('/^[A-E]{2}[1-9][0-9]*/', $input))
                return false;

        return true;
    }
}
