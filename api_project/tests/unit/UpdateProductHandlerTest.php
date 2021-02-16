<?php

namespace App\Tests\unit;

use App\Commands\UpdateProduct;
use App\Commands\UpdateProductHandler;
use App\Entity\Product;
use App\Entity\ProductId;
use App\Events\ProductWasUpdated;
use App\Repository\ProductRepository;
use App\Tests\unit\Utilities\InspectableMessengerDispatcher;
use App\Tests\unit\Utilities\ProductRepositoryMock;
use PHPUnit\Framework\TestCase;

class UpdateProductHandlerTest extends TestCase
{
    private InspectableMessengerDispatcher  $eventBus;

    private ProductRepository $productRepository;

    private UpdateProductHandler     $handler;

    protected function setUp(): void
    {
        $this->eventBus = new InspectableMessengerDispatcher();
        $this->productRepository =  new ProductRepositoryMock();

        $this->handler = new UpdateProductHandler(
            $this->productRepository,
            $this->eventBus,
        );
    }

    public function testCreatesAnEventWhenProductIsUpdated()
    {
        $command = UpdateProduct::fromRequest(
            '00000000-0000-0000-0000-000000000000',
            'some name',
            10,
            'some description'
        );
        $this->productRepository->update(Product::create(ProductId::fromString($command->id()), $command->name(), $command->price(), $command->description()));

        $this->handler->__invoke($command);

        $this->assertTrue($this->eventBus->contains(ProductWasUpdated::class));
    }
}
