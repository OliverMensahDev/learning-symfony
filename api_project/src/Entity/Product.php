<?php

namespace App\Entity;

final class Product
{

    private ProductId $id;

    private string $name;

    private int $price;

    private string $description;

    public static function create(ProductId $id, string $name, int $price, string $description): self
    {
        $self = new self();
        $self->id = $id;
        $self->name = $name;
        $self->price = $price;
        $self->description = $description;

        return $self;
    }

    public function getId():  ProductId
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
