<?php

namespace App\Presentation\Protocols;

class Request implements RequestInterface
{
    private array $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function body(): array
    {
        return $this->body;
    }
}
