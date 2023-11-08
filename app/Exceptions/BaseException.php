<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class BaseException extends Exception implements HttpExceptionInterface
{
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->getCode() !== 0 ? $this->getCode() : 500;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }
}
