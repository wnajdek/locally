<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Stall.php';
require_once __DIR__.'/../repository/StallRepository.php';
require_once __DIR__.'/../repository/ProductRepository.php';

class StallController extends AppController {

    const MAX_FILE_SIZE = 1024*1024*1024*16;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const UPLOAD_DIRECTORY = '/../public/uploads/stalls/';

    private $messages = [];

    private $stallRepository;
    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->stallRepository = new StallRepository();
        $this->productRepository = new ProductRepository();
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
        var_dump($_SESSION);
        if (func_num_args() == 0 || !func_get_arg(0)) {
            $stalls = $this->stallRepository->getStalls();

            $this -> render('market', ['stalls' => $stalls]);
        } else {
            $id = (int) func_get_arg(0);
            $stall = $this->stallRepository->getStall($id);

            $products = $this->productRepository->getProducts($id);
            $this -> render('stall', ['products' => $products, 'stalls' => $stall]);
        }

    }


    public function search() {
        $type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

        if ($type === 'application/json') {
            $body = trim(file_get_contents('php://input'));
            $bodyDecoded = json_decode($body, true);

            header('Content-Type: application/json');
            http_response_code(200);

            if ($bodyDecoded['searchBy'] === "stall name") {
                echo json_encode($this->stallRepository->getStallByName($bodyDecoded['searchValue']));
            } elseif ($bodyDecoded['searchBy'] === "category") {
                echo json_encode($this->stallRepository->getStallByCategory($bodyDecoded['searchValue']));
            }

        }
    }

    public function like(int $id) {
        $this->stallRepository->like($id);
        http_response_code(200);
    }
}