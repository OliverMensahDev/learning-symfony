<?php


namespace App\Repository;


use App\Entity\Product;
use App\Entity\ProductId;
use App\Entity\Products;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

final class DbalProductRepository implements ProductRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(ProductId $id): ?Product
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from('product')
            ->where('product_id = :id')
            ->setParameter('id', $id->toString());
        $queryStatement = $queryBuilder->execute();

        $row = $queryStatement->fetch(FetchMode::ASSOCIATIVE);
        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function findAll(): Products
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from('product');

        $queryStatement = $queryBuilder->execute();

        $licenses = [];
        while (($row = $queryStatement->fetch(FetchMode::ASSOCIATIVE)) !== false) {
            $licenses[] = $this->hydrate($row);
        }

        return Products::create($licenses);
    }

    public function save(Product $product): void
    {
        $this->connection->createQueryBuilder()
            ->insert('product')
            ->values(
                [
                    'name' => ':name',
                    'price' => ':price',
                    'description' => ':description',
                    'product_id' => ':id'
                ]
            )->setParameters(
                [
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'description' => $product->getDescription(),
                    'id' => $product->getId()->toString()
                ]
            )->execute();
    }

    public function update(Product $product): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->update('product')
            ->set('name', ':name')
            ->set('price', ':price')
            ->set('description', ':description')
            ->where('product_id = :id')
            ->setParameters(
                [
                    'id' => $product->getId()->toString(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'description' => $product->getDescription()
                ]
            );

        $queryBuilder->execute();
    }

    public function delete(ProductId $id): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->delete('product')
            ->where('product_id = :id')
            ->setParameters(
                [
                    'id' => $id->toString()
                ]
            );

        $queryBuilder->execute();
    }

    private function hydrate(array $row): Product
    {
        return Product::create(
            ProductId::fromString($row['product_id']),
            $row['name'],
            (int) $row['price'],
            $row['description']
        );
    }

    public function productIdentity(): ProductId
    {
        return ProductId::generate();
    }
}
