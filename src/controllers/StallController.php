<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Stall.php';
require_once __DIR__.'/../repository/StallRepository.php';
require_once __DIR__.'/../repository/ProductRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class StallController extends AppController {

    const MAX_FILE_SIZE = 1024*1024*1024*16;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const UPLOAD_DIRECTORY = '/../public/uploads/stalls/';

    private $messages = [];

    private $stallRepository;
    private $productRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->stallRepository = new StallRepository();
        $this->productRepository = new ProductRepository();
        $this->userRepository = new UserRepository();
    }

    public function addStall() {
        if ($this->isPost() && is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
            //TODO: change images location to avoid duplicated file name problem (add id of stall for example)
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['image']['name']
            );

            $stall = new Stall($_POST['name'], $_POST['description'], $_FILES['image']['name']);
            $this->stallRepository->addStall($stall);

            return $this->render("market", ['messages' => $this->messages, 'stalls' => $this->stallRepository->getStalls()]);
        }

        $this->render('market', ['messages' => $this->messages]);
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

    public function market() {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $this -> render('login', ['messages' => ['You have to log in first.']]);
        }

        var_dump($_SESSION);
        var_dump($this->userRepository->getLikedStallsIds($_SESSION['userId']));
        if (func_num_args() == 0 || !func_get_arg(0)) {
            $stalls = $this->stallRepository->getStalls();
            $likedStalls = $this->userRepository->getLikedStallsIds($_SESSION['userId']);

            $this -> render('market', ['stalls' => $stalls, 'likedStalls' => $likedStalls]);
        } else {
            $id = (int) func_get_arg(0);
            $stall = $this->stallRepository->getStall($id);

            $products = $this->productRepository->getProducts($id);
            $buttonsEnabled = false; // enable buttons if user access his own store
            if ($stall->getUserId() == $_SESSION['userId']) {
                $buttonsEnabled = true;

            }
            $stallId = $stall->getId();

            $this -> render('stall', ['products' => $products, 'stalls' => $stall,
                'buttonsEnabled' => $buttonsEnabled, 'stallId' => $stallId,
                'status' => $stall->getPublic()]);
        }

    }


    public function search() {
        session_start();
        $type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

        if ($type === 'application/json') {
            $body = trim(file_get_contents('php://input'));
            $bodyDecoded = json_decode($body, true);

            header('Content-Type: application/json');
            http_response_code(200);

            $stalls = [];

            if ($bodyDecoded['searchBy'] === "stall name") {
                $stalls = $this->stallRepository->getStallByName($bodyDecoded['searchValue']);
            } elseif ($bodyDecoded['searchBy'] === "category") {
                $stalls = $this->stallRepository->getStallByCategory($bodyDecoded['searchValue']);
            } elseif ($bodyDecoded['searchBy'] === "product") {
                $stalls = $this->stallRepository->getStallByProductName($bodyDecoded['searchValue']);
            }

            $likedStalls = $this->userRepository->getLikedStallsIds($_SESSION['userId']);
            for ($i = 0; $i < count($stalls); $i++) {
                if (in_array($stalls[$i]['id'], $likedStalls)){
                    $stalls[$i]['isLiked'] = true;
                } else {
                    $stalls[$i]['isLiked'] = false;
                }
            }

            echo json_encode($stalls);
        }
    }

    public function like(int $id) {
        session_start();

        header('Content-Type: application/json');
        http_response_code(200);

        if (in_array($id, $this->userRepository->getLikedStallsIds($_SESSION['userId']))) {
            $this->stallRepository->dislike($id, $_SESSION['userId']);
            echo '{"isLike": false}';
        } else {
            $this->stallRepository->like($id, $_SESSION['userId']);
            echo '{"isLike": true}';
        }


    }

    public function changeVisibility() {
        session_start();

        $stall = $this->stallRepository->getStall($_SESSION['userStallId']);
        $stall->setPublic(!$stall->getPublic());
        $this->stallRepository->updateStall($stall);

        http_response_code(200);
    }

    public function my_products() {
        session_start();
        $stallId = $_SESSION['userStallId'];
        $products = $this->productRepository->getProducts($stallId);
        $stall = $this->stallRepository->getStall($stallId);

        $this -> render('my_products', ['products' => $products, 'stallId' => $stallId,
            'status' => $stall->getPublic()]);
    }
}