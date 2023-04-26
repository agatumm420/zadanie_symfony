<?php
namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiException extends \RuntimeException implements HttpExceptionInterface
{
private int $statusCode;
private array $headers;

public function __construct(int $statusCode, string $message = null, array $headers = [], \Throwable $previous = null)
{
$this->statusCode = $statusCode;
$this->headers = $headers;
parent::__construct($message, 0, $previous);
}

public function getStatusCode(): int
{
return $this->statusCode;
}

public function getHeaders(): array
{
return $this->headers;
}
}