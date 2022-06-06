<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Product.php';
require_once __DIR__.'/../repository/ProductRepository.php';

class ProductController extends AppController {

    const MAX_FILE_SIZE = 1024*1024*1024*16;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const UPLOAD_DIRECTORY = '/../public/uploads/products/';

    private $messages = [];

    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    public function addProduct() {
        if ($this->isPost() && is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
            //TODO: change images location to avoid duplicated file name problem (add id of stall for example)
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['image']['name']
            );

            $product = new Product($_POST['name'], $_POST['description'], $_POST['price'], $_FILES['image']['name']);
            $this->productRepository->addProduct($product);

            return $this->render("my_products", ['messages' => $this->messages, 'products' => $this->productRepository->getProducts()]);
        }

        $this->render('my_products', ['messages' => $this->messages]);
    }

    private function validate(array $file): bool {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is to large for our destination file system';
            return false;
        }

        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported';
            return false;
        }

        return true;
    }

    public function my_products() {
        $products = $this->productRepository->getProducts();

        $this -> render('my_products', ['products' => $products]);
    }
}