<?php

namespace App\Commands;

final class DeleteProduct
{
    private int $id;

    public static function create(int $id): self
    {
        $self = new self;
        $self->id = $id;

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    private function __construct()
    {

    }
}
