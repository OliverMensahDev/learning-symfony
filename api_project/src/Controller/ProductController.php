<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function createProduct(Request $request, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $parameters = json_decode($request->getContent(), true);
        dd($request->getContent());
        $product->setName($parameters['name']);
        $product->setPrice($parameters['price']);
        $product->setDescription($parameters['description']);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], 400);
        }
        $entityManager->persist($product);
        $entityManager->flush();

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
     * @Route("/products/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
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
        return $this->json([
                'code' => 200,
                'data' => []
            ]
        );
    }
}
