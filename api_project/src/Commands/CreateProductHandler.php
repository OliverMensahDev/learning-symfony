<?php

namespace App\Commands;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Events\ProductWasCreated;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateProductHandler implements MessageHandlerInterface
{
    private  ProductRepository $productRepository;

    private MessageBusInterface $eventBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateProduct $command)
    {
        $this->productRepository->save(Product::create(
            ProductId::fromString($command->getId()),
            $command->getName(),
            $command->getPrice(),
            $command->getDescription()
        ));
        $this->eventBus->dispatch(ProductWasCreated::create($command->getId()));
    }
}
