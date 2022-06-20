<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Product.php';

class ProductRepository extends Repository
{
    public function getProduct(int $id): ?Product {
        $statement = $this->database->connect()->prepare(
            "SELECT * FROM public.product WHERE id = :id"
        );
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null;
        }
        $productTypeId = 1;
        $stallId = 1;
        return new Product(
            $product['name'],
            $product['description'],
            $product['price'],
            $product['image'],
            $product['product_type_id'],
            $product['stall_id'],
            $product['id']
        );
    }

    public function addProduct(Product $product): void {
//
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

    public function getProducts(): ?array {
        $result = [];

        if (func_num_args() == 0) {
            $statement = $this->database->connect()->prepare('
                SELECT * FROM public.product
            ');
        } else {
            $statement = $this->database->connect()->prepare('
                SELECT * FROM public.product WHERE stall_id = :stallId
            ');
            $stallId = func_get_arg(0);
            $statement->bindParam(':stallId', $stallId, PDO::PARAM_INT);
        }

        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        $productTypeId = 1;
        $stallId = 1;
        foreach ($products as $product) {
            $result[] = new Product(
                $product['name'],
                $product['description'],
                $product['price'],
                $product['image'],
                $product['product_type_id'],
                $product['stall_id'],
                $product['id']
            );
        }

        return $result;
    }
}