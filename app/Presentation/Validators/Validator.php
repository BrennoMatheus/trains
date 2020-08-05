<?php

namespace App\Presentation\Validators;

use App\Presentation\Protocols\ValidatorInterface;

class Validator implements ValidatorInterface
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $data): bool
    {
        foreach ($data as $input)
            if (!preg_match('/[A-E][A-E][1-9][0-9]*/', $input))
                return false;

        return true;
    }
}
