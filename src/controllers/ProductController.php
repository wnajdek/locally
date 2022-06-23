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
        session_start();
        if (!isset($_SESSION['userStallId'])) {
            $this->render('login', ['messages' => ['You have to log in first.']]);
        }

        $stallId = $_SESSION['userStallId'];

        if ($this->isPost() && is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
            if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'])) {
                mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'], 0777, true);
            }
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'] . '/' . $_FILES['image']['name']
            );


            var_dump($_SESSION['userStallId']);
            $product = new Product(
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_FILES['image']['name'],
                1,
                $stallId
            );
            $this->productRepository->addProduct($product);
        }

        return $this->render("my_products", ['messages' => $this->messages,
            'products' => $this->productRepository->getProducts($stallId),
            'stallId' => $stallId]);
    }

    public function updateProduct() {
        session_start();
        if (!isset($_SESSION['userStallId'])) {
            $this->render('login', ['messages' => ['You have to log in first.']]);
        }

        $stallId = $_SESSION['userStallId'];
        var_dump($_SESSION['userStallId']);

        if ($this->isPost() && $this->validate($_FILES['image'])) {

            $image = null;
            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'])) {
                    mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'], 0777, true);
                }
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'] . '/' . $_FILES['image']['name']
                );

                $image = $_FILES['image']['name'];
            } else {
                $image = $this->productRepository->getProduct($_POST['id'])->getImage();  // save with old image
            }


            $product = new Product(
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $image,
                1,
                $stallId,
                $_POST['id']
            );
            $this->productRepository->updateProduct($product);
        }

        return $this->render("my_products", ['messages' => $this->messages,
            'products' => $this->productRepository->getProducts($stallId),
            'stallId' => $stallId]);
    }

    public function deleteProduct() {
        session_start();
        if (!isset($_SESSION['userStallId'])) {
            $this->render('login', ['messages' => ['You have to log in first.']]);
        }

        $stallId = $_SESSION['userStallId'];
        var_dump($_SESSION['userStallId']);

        if ($this->isPost()) {
            $this->productRepository->deleteProduct($_POST['id']);
        }

        return $this->render("my_products", ['messages' => $this->messages,
            'products' => $this->productRepository->getProducts($stallId),
            'stallId' => $stallId]);
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


}