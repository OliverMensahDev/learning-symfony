<?php

namespace App\Commands;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Events\ProductWasUpdated;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateProductHandler implements MessageHandlerInterface
{
    private  ProductRepository $productRepository;

    private MessageBusInterface $eventBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UpdateProduct $command)
    {
        $this->productRepository->update(Product::create(
            ProductId::fromString($command->id()),
            $command->name(),
            $command->price(),
            $command->description()
        ));
        $this->eventBus->dispatch(ProductWasUpdated::create($command->id()));
    }
}
