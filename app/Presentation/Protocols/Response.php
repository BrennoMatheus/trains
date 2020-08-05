<?php

namespace App\Presentation\Protocols;

class Response implements ResponseInterface
{
    private int $statusCode;
    private $body;

    public function __construct(int $statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
