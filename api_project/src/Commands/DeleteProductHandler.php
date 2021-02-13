<?php

namespace App\Commands;

use App\Events\ProductWasDeleted;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteProductHandler implements MessageHandlerInterface
{
    private  ProductRepository $productRepository;

    private MessageBusInterface $eventBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(DeleteProduct $command)
    {
        $this->productRepository->delete($command->id());
        $this->eventBus->dispatch(ProductWasDeleted::create($command->id()));
    }
}
