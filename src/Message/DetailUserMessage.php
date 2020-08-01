<?php

namespace App\Message;

final class DetailUserMessage
{
    private int $userId;
    private array $data;

    public function __construct(int $id)
    {
        $this->userId = $id;
        $this->data = [];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setData(array $data)
    {
        $this->data[] = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}