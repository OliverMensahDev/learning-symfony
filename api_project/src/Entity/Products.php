<?php


namespace App\Entity;



use Webmozart\Assert\Assert;

final class Products implements \IteratorAggregate
{
    /**
     * @var Product[]
     */
    private $products;

    public static function create(array $products): self
    {
        Assert::allIsInstanceOf($products, Product::class);

        $object = new self();
        $object->products = $products;

        return $object;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->products);
    }

    public function contains(Products $license): bool
    {
        return in_array($license, $this->products);
    }

    private function __construct()
    {
    }
}
