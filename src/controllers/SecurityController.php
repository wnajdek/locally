<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {
    const MAX_FILE_SIZE = 1024*1024*1024*16;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const UPLOAD_DIRECTORY = '/../public/uploads/users/';

    public function login() {
        $userRepository = new UserRepository();
//        $user = new User("tomjones@gmail.com", "password", 'Tom', 'Jones');

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['message' => ['User not exists.']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/market");
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
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

        $user->setPhone($phoneNumber);
        $user->setMainAddress($mainAddressLine);
        $user->setLocationDetails($locationDetails);
        $user->setCity($city);
        $user->setPostalCode($postalCode);
        $user->setImage($image);


        $this->userRepository->addUser($user);

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