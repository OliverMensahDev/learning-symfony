<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private  ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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
                "id" => $product->getId(),
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
        $this->productRepository->save(Product::create(
            $parameters['name'],
            $parameters['price'],
            $parameters['description']
        ));
        return $this->json([
                'code' => 200,
                'data' => []
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
                    "id" => $product->getId(),
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
        $newProduct = Product::create(
            isset($parameters['name'])?$parameters['name']:$product->getName(),
        isset($parameters['price'])?$parameters['price']: $product->getPrice(),
            isset($parameters['description'])?$parameters['description']: $product->getDescription()
        );
        $newProduct->setId($product->getId());
        $this->productRepository->update($newProduct);
        return $this->json([
                'code' => 200,
                'data' => [
                    "id" => $newProduct->getId(),
                    "name" => $newProduct->getName(),
                    "price" => $newProduct->getPrice(),
                    "description" => $newProduct->getDescription(),
                ]
            ]
        );
    }

    /**
     * @Route("/products/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $this->productRepository->delete($id);
        return $this->json([
                'code' => 200,
                'data' => []
            ]
        );
    }
}
