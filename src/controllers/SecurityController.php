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

    public function index() {
        session_start();

        if (isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/market");
        }

        $this -> render('login');
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

        $_SESSION['isAdmin'] = $user->getRole() == 'ADMIN';
//        if (!$_SESSION['isAdmin']) {
//            $stall = $this->stallRepository->getStallByUserId($user->getId());
//            $_SESSION['userStallId'] = $stall->getId();
//        } else {
//            $_SESSION['userStallId'] = 0;
//        }
        $stall = $this->stallRepository->getStallByUserId($user->getId());
        $_SESSION['userStallId'] = $stall->getId();
        $_SESSION['userId'] = $user->getId();
        $_SESSION['userEmail'] = $user->getEmail();


        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/market");
    }

    public function logout() {
        session_start();
        unset($_SESSION['userId']);
        unset($_SESSION['userEmail']);
        unset($_SESSION['userStallId']);
        unset($_SESSION['isAdmin']);
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
//        return $this->render('login', ['messages' => 'You have been successfully logged out.']);

    }

    public function register()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/market");
        }

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
            $lastName,
            'USER'
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
            $userFromDb->getId()
        );

        $this->stallRepository->addStall($stall);

        return $this->render('login', ['messages' => ['You\'re a part of Locally! Now You can log in.']]);
    }

    public function user() {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
        }

        $user = $this->userRepository->getUser($_SESSION['userEmail']);

        return $this->render('user', ['user' => $user]);
    }

    public function updateUserData() {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
        }

        $user = $this->userRepository->getUser($_SESSION["userEmail"]);
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setPhoneNumber($_POST['phoneNumber']);
        $user->setMainAddress($_POST['mainAddress']);
        $user->setLocationDetails($_POST['locationDetails']);
        $user->setCity($_POST['city']);
        $user->setPostalCode($_POST['postalCode']);

        if (is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
            if (!file_exists(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email)) {
                mkdir(dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email, 0777, true);
            }
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $email . '/' . $_FILES['image']['name']
            );

            $user->setImage($_FILES['image']['name']);
        }

        $this->userRepository->updateUser($user);


        return $this->render('user', ['messages' => ['User successfully updated'], 'user' => $user]);
    }

    public function changePassword() {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
        }

        $currentPassword = $_POST['passwordOld'];
        $newPassword = $_POST['password'];
        $confirmedPassword = $_POST['passwordRepeat'];

        $user = $this->userRepository->getUser($_SESSION['userEmail']);

        if (!password_verify($currentPassword, $user->getPassword())) {
            return $this->render('user', ['messages' => ['Wrong current password!'], 'user' => $user]);
        }

        if ($newPassword !== $confirmedPassword) {
            return $this->render('user', ['messages' => ['New password fields values must be the same.'], 'user' => $user]);
        }


        $user->setPassword(password_hash($newPassword, PASSWORD_BCRYPT),);
        $this->userRepository->updateUser($user);

        return $this->render('user', ['messages' => ['Password updated'], 'user' => $user]);
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