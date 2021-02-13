<?php

namespace App\Commands;

final class CreateProduct
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getPrice(): int
    {
        return $this->price;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    private function __construct()
    {
    }
}
