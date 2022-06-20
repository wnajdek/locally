<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Stall.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/StallRepository.php';

class SecurityController extends AppController {
    const MAX_FILE_SIZE = 1024*1024*1024*16;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const UPLOAD_DIRECTORY = '/../public/uploads/users/';

    private $userRepository;
    private $stallRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->stallRepository = new StallRepository();
    }

    public function login() {

        session_start();
        if (isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/market");
        }

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['message' => ['User not exists.']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $stall = $this->stallRepository->getStallByUserId($user->getId());
        $_SESSION['userId'] = $user->getId();
        $_SESSION['userEmail'] = $user->getEmail();
        $_SESSION['userStallId'] = $stall->getId();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/market");
    }

    public function logout() {
        session_start();
        unset($_SESSION['userId']);
        unset($_SESSION['userEmail']);
        unset($_SESSION['userStallId']);
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
//        return $this->render('login', ['messages' => 'You have been successfully logged out.']);

    }

    public function register()
    {
        session_start();
        if (!$this->isPost()) {
            return $this->render('register');
        }


        $email = $_POST['email'];
        $user = $this->userRepository->getUser($email);
        if ($user) {
            return $this->render('register', ['message' => ['User already exists.']]);
        }

        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phoneNumber = $_POST['phone'];
        $mainAddressLine = $_POST['mainAddressLine'];
        $locationDetails = $_POST['locationDetails'];
        $city = $_POST['city'];
        $postalCode = $_POST['postalCode'];




        if ($password !== $passwordRepeat) {
            return $this->render('register', ['messages' => ['Password and repeated password don\'t match. Please try ry again.']]);
        }

        if (is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
            if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email)) {
                mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email, 0777, true);
            }
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email . '/' . $_FILES['image']['name']
            );
        }
        $image = $_FILES['image']['name'];



        $user = new User(
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            $firstName,
            $lastName
        );

        $user->setPhoneNumber($phoneNumber);
        $user->setMainAddress($mainAddressLine);
        $user->setLocationDetails($locationDetails);
        $user->setCity($city);
        $user->setPostalCode($postalCode);
        $user->setImage($image);


        $this->userRepository->addUser($user);

        $userFromDb = $this->userRepository->getUser($email);

//        var_dump($userFromDb->getId());
//        var_dump($userFromDb);
        $stall = new Stall(
            explode('@', $email)[0] . '\'s bazaar',
            'Here is a place for more info about your bazaar',
            'default.jpg',
            0,
            0,
            new DateTime(),
            1,
            $userFromDb->getId()
        );

        $this->stallRepository->addStall($stall);

        return $this->render('login', ['messages' => ['You\'re a part of Locally! Now You can log in.']]);
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