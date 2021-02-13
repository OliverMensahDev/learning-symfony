<?php

namespace App\Controller;

use App\Commands\CreateProduct;
use App\Commands\DeleteProduct;
use App\Commands\UpdateProduct;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    private  ProductRepository $productRepository;

    private MessageBusInterface $commandBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $commandBus)
    {
        $this->productRepository = $productRepository;
        $this->commandBus = $commandBus;
    }
    /**
     * @Route("/products", name="get_products", methods={"GET"})
     */
    public function index(): Response
    {

        $products = $this->productRepository->findAll();
        $json = [];
        foreach ($products as $product){
            $json[] = [
                "id" => $product->getId()->toString(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription(),
            ];
        }
        return $this->json([
                'code' => 200,
                'data' => $json
            ]
        );

    }

    /**
     * @Route("/products", name="create_product", methods={"POST"})
     */
    public function createProduct(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $productId = $this->productRepository->productIdentity();
        $this->commandBus->dispatch(CreateProduct::fromRequest(
            $productId->toString(),
            $parameters['name'],
            $parameters['price'],
            $parameters['description']
        ));
        return $this->json([
                'code' => 200,
                'data' => [
                    'id' => $productId->toString()
                ]
            ]
        );
    }

    /**
     * @Route("/products/{id}", name="product_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        return $this->json([
                'code' => 200,
                'data' => [
                    "id" => $product->getId()->toString(),
                    "name" => $product->getName(),
                    "price" => $product->getPrice(),
                    "description" => $product->getDescription(),
                ]
            ]
        );
    }

    /**
     * @Route("/products/{id}", methods={"PUT"})
     */
    public function update(Request $request, int $id): Response
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $parameters = json_decode($request->getContent(), true);
        $this->commandBus->dispatch(UpdateProduct::fromRequest(
            $product->getId()->toString(),
            isset($parameters['name'])?$parameters['name']:$product->getName(),
            isset($parameters['price'])?$parameters['price']: $product->getPrice(),
            isset($parameters['description'])?$parameters['description']: $product->getDescription()
        ));
        return $this->json([
                'code' => 200,
                'data' => [
                    'id' => $product->getId()->toString()
                ]
            ]
        );
    }

    /**
     * @Route("/products/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

       $this->commandBus->dispatch(DeleteProduct::create($id));
        return $this->json([
                'code' => 200,
                'data' => []
            ]
        );
    }
}
