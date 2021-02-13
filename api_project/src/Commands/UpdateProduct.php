<?php

namespace App\Commands;

final class UpdateProduct
{
    private string $id;

    private string $name;

    private int $price;

    private string $description;

    public static function fromRequest(string $id, string $name, int $price, string $description): self
    {
        $self = new self();
        $self->id = $id;
        $self->name = $name;
        $self->price = $price;
        $self->description = $description;

        return $self;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }


    public function price(): int
    {
        return $this->price;
    }


    public function description(): string
    {
        return $this->description;
    }

    private function __construct()
    {
    }
}
