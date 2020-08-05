<?php

namespace App\Presentation\Protocols;

interface ResponseInterface
{
    public function getBody();
    public function getStatusCode(): int;
}
