<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\Products;


interface ProductRepository
{
    public function find(int $id):  ?Product;
    public function findAll(): Products;
    public function save(Product $product):  void;
    public function update(Product $product): void;
    public function delete(int $id): void;
    public function productIdentity(): ProductId;
}
