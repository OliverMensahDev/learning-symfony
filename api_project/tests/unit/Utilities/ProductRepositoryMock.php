<?php


namespace App\Tests\unit\Utilities;


use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\Products;
use App\Repository\ProductRepository;

class ProductRepositoryMock implements ProductRepository
{

    public function find(int $id): ?Product
    {
        // TODO: Implement find() method.
    }

    public function findAll(): Products
    {
        // TODO: Implement findAll() method.
    }

    public function save(Product $product): void
    {
        // TODO: Implement save() method.
    }

    public function update(Product $product): void
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }

    public function productIdentity(): ProductId
    {
        // TODO: Implement productIdentity() method.
    }
}
