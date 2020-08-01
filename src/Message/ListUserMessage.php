<?php

namespace App\Message;

final class ListUserMessage
{
    private array $data;

    public function __construct()
    {
        $this->data = [];
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