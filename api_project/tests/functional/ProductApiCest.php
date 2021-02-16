<?php

namespace  App\Tests\functional;

use App\Entity\Product;
use App\Entity\ProductId;
use App\Kernel;
use App\Repository\DbalProductRepository;
use FunctionalTester;
use Codeception\Util\HttpCode;
use Symfony\Component\Dotenv\Dotenv;

class ProductApiCest
{
    public function getProducts(FunctionalTester $I)
    {
        $I->sendGet('/products');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function getProductById(FunctionalTester $I)
    {
        $I->sendGet('/products/17');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function createProductViaAPI(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/products', [
            'name' => 'Some name',
            'price' => 10,
            "description" => 'Some description'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeInDatabase(
            'product',
            [
                'name'             => 'Some name',
                'price'             => 10,
                'description' => 'Some description'
            ]
        );
    }

    public function updateProductViaAPI(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/products/17', [
            'name' => 'Updated some name',
            'price' => 10,
            "description" => 'Updated some description'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeInDatabase(
            'product',
            [
                'name' => 'Updated some name',
                'price' => 10,
                "description" => 'Updated some description'
            ]
        );
    }

    public function testSaveProductInDatabase(\FunctionalTester $I)
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
