<?php

namespace App\Entity;

final class Product
{

    private int $id;

    private string $name;

    private int $price;

    private string $description;

    public static function create(string $name, int $price, string $description): self
    {
        $self = new self();
        $self->name = $name;
        $self->price = $price;
        $self->description = $description;

        return $self;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function getPrice(): ?int
    {
        return $this->price;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    private function __construct()
    {
    }
}
