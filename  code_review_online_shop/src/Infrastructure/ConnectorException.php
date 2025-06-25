<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure;

class ConnectorException implements \Throwable
{
    public function __construct(
        private string $message,
        private int $code,
        private ?\Throwable $previous,
    ) { }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getFile(): string
    {
        return $this->previous->getFile();
    }

    public function getLine(): int
    {
        return $this->previous->getLine();
    }

    public function getTrace(): array
    {
        return $this->previous->getTrace();
    }

    public function getTraceAsString(): string
    {
        return $this->previous->getTraceAsString();
    }

    public function getPrevious(): ?\Throwable
    {
        return $this->previous;
    }

    public function __toString(): string
    {
        return sprintf(
            '[%s] %s in %s on line %d',
            $this->getCode(),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine(),
        );
    }
}
