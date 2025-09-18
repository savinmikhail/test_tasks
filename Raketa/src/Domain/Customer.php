<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain;

final readonly class Customer
{
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName,
        private string $middleName,
        private string $email,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
