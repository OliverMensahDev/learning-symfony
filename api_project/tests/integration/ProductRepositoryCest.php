<?php

use App\Entity\Product;
use App\Entity\ProductId;
use App\Kernel;
use App\Repository\DbalProductRepository;
use Symfony\Component\Dotenv\Dotenv;

class ProductRepositoryCest
{

    public function savesProductInDatabase(\IntegrationTester $I)
    {
        (new Dotenv())->bootEnv('.env');
        $kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
        $kernel->boot();
        $container = $kernel->getContainer();
        $productRepository = new DbalProductRepository($container->get('database_connection'));

        $productRepository->save(
            Product::create(
                ProductId::fromString('00000000-0000-0000-0000-000000000000'),
                'some name',
                10,
                'some description'
            )
        );
        $I->canSeeInDatabase(
            'product',
            [
                'product_id' => '00000000-0000-0000-0000-000000000000',
                'name' => 'some name',
                'price' => 10,
                'description' =>'some description'
            ]
        );
    }

}
