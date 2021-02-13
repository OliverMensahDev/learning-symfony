<?php

namespace App\Events;

final class ProductWasUpdated
{
    private string $id;

    public static function create(string $id): self
    {
        $self = new self;
        $self->id = $id;

        return $self;
    }

    public function id(): string
    {
        return $this->id;
    }

    private function __construct()
    {

    }
}
