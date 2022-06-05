<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Product.php';

class ProductRepository extends Repository
{
    public function getProduct(int $id): ?Product {
        $statement = $this->database->connect()->prepare(
            "SELECT * FROM public.product WHERE email = :id"
        );
        $statement->bindParam(':email', $id, PDO::PARAM_INT);
        $statement->execute();

        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null;
        }

        return new Product(
            $product['name'],
            $product['description'],
            $product['price'],
            $product['image']
        );
    }

    public function addProduct(Product $product): void {
//        $date = new DateTime();
        $statement = $this->database->connect()->prepare(
            'INSERT INTO public.product (name, description, price, image, product_type_id, stall_id)
            VALUES (?, ?, ?, ?, ?, ?)'
        );

//        $assignedById = 1;
        $productTypeId = 1;
        $stall_id = 1;
        $statement->execute([
            $product->getName(),
            $product->getDescription(),
            $product->getPrice(),
            $product->getImage(),
            $productTypeId,
            $stall_id
        ]);
    }
}