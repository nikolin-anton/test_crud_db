<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class BaseException extends Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return $this->getCode() !== 0 ? $this->getCode() : 500;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
