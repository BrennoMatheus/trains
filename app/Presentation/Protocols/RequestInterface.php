<?php

namespace App\Presentation\Protocols;

interface RequestInterface
{
    public function body(): array;
}
