<?php

namespace App\Presentation\Protocols;

interface ControllerInterface
{
    public function handle(RequestInterface $request): ResponseInterface;
}
