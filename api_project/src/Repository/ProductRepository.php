<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\Products;


interface ProductRepository
{
    public function find(ProductId $id):  ?Product;
    public function findAll(): Products;
    public function save(Product $product):  void;
    public function update(Product $product): void;
    public function delete(ProductId $id): void;
    public function productIdentity(): ProductId;
}
