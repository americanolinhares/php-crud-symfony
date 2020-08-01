<?php

namespace App\Message;

final class CreateUserMessage
{
    private ?int $id = null;
    private string $name;
    private string $email;
    private array $telephones;

    public function __construct(string $name, string $email, array $telephones)
    {
        $this->id = rand(1, 100);
        $this->name = $name;
        $this->email = $email;
        $this->telephones = $telephones;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephones(): array
    {
        return $this->telephones;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
