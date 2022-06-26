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

//    public function addProduct() {
//        session_start();
//        if (!isset($_SESSION['userStallId'])) {
//            $this->render('login', ['messages' => ['You have to log in first.']]);
//        }
//
//        $stallId = $_SESSION['userStallId'];
//
//        if ($this->isPost() && is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
//            if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'])) {
//                mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'], 0777, true);
//            }
//            move_uploaded_file(
//                $_FILES['image']['tmp_name'],
//                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'] . '/' . $_FILES['image']['name']
//            );
//
//
//            var_dump($_SESSION['userStallId']);
//            $product = new Product(
//                $_POST['name'],
//                $_POST['description'],
//                $_POST['price'],
//                $_FILES['image']['name'],
//                1,
//                $stallId
//            );
//            $this->productRepository->addProduct($product);
//        }
//
//        return $this->render("my_products", ['messages' => $this->messages,
//            'products' => $this->productRepository->getProducts($stallId),
//            'stallId' => $stallId]);
//    }

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


            header('Content-Type: application/json');
            http_response_code(200);
            $product = new Product(
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_FILES['image']['name'],
                1,
                $stallId
            );
            $productId = $this->productRepository->addProduct($product);
//            var_dump($productId);


            $productFromDb = $this->productRepository->getProduct($productId);
//            var_dump($productFromDb);
//            echo mb_detect_encoding($productFromDb->getName());
//            echo mb_detect_encoding($productFromDb->getName());
            echo json_encode([
                'name'=>$productFromDb->getName(),
                'image'=>$productFromDb->getImage(),
                'description'=>$productFromDb->getDescription(),
                'price'=>$productFromDb->getPrice(),
                'id'=>$productFromDb->getId(),
                'stallId'=>$productFromDb->getStallId(),
                'productTypeId'=>$productFromDb->getProductTypeId()
            ]);
        }
    }

    public function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }


//    public function addProduct() {
//        session_start();
//        $type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
//
//        if ($type === 'application/json') {
//            $body = trim(file_get_contents('php://input'));
//            $bodyDecoded = json_decode($body, true);
//
//            header('Content-Type: application/json');
//            http_response_code(200);
//            if (is_uploaded_file($bodyDecoded['image']['name']) && $this->validate($bodyDecoded['image'])) {
//                if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'])) {
//                    mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'], 0777, true);
//                }
//                move_uploaded_file(
//                    $bodyDecoded['image']['name'],
//                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_SESSION['userStallId'] . '/' . $bodyDecoded['image']['name']
//                );
//
//
//                var_dump($_SESSION['userStallId']);
//                $product = new Product(
//                    $bodyDecoded['name'],
//                    $bodyDecoded['description'],
//                    $bodyDecoded['price'],
//                    $bodyDecoded['image']['name'],
//                    1,
//                    $_SESSION['userStallId']
//                );
//                $productId = $this->productRepository->addProduct($product);
//
//                echo json_encode($this->productRepository->getProduct($productId));
//            }
//
//
//        }
//    }

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