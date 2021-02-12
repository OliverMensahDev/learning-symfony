<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="get_products", methods={"GET"})
     */
    public function index(): Response
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        $json = [];
        foreach ($products as $product){
            $json[] = [
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription(),
            ];
        }
        return $this->json(['products' => $json]);

    }

    /**
     * @Route("/products", name="create_product", methods={"POST"})
     */
    public function createProduct(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/products/{id}", name="product_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->json(
            ['product' => [
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
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->json(
            ['product' => [
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription(),
            ]
            ]
        );
    }

    /**
     * @Route("/products/{id}", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();
    }
}
