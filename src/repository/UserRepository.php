<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User {
        $statement = $this->database->connect()->prepare(
            "SELECT * FROM public.user WHERE email = :email"
        );
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }

    public function addUser(User $user)
    {
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.address (main_address, location_details, city, postal_code)
            VALUES (?, ?, ?, ?)
        ');
        $statement->execute([
            $user->getMainAddress(),
            $user->getLocationDetails(),
            $user->getCity(),
            $user->getPostalCode()
        ]);

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.users_details (first_name, last_name, phone_number, address_id, image)
            VALUES (?, ?, ?, ?, ?)
        ');

        $statement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhoneNumber(),
            $user->getAddressId(),
            $user->getImage()
        ]);

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.users (email, password, enabled, salt, created_at, id_user_details, role_id)
            VALUES (?, ?, ?)
        ');

        $enabled = true;
        $salt = 1;
        $createdAt = new DateTime();
        $roleId = 1;


        $statement->execute([
            $user->getEmail(),
            $user->getPassword(),
            $enabled,
            $salt,
            $createdAt,
            $this->getUserDetailsId($user),
            $roleId
        ]);
    }

    public function getAddressId(User $user): int
    {
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.address WHERE main_address = :mainAddress AND location_details = :locationDetails AND city = :city AND postal_code = :postalCode
        ');

        $mainAddress = $user->getMainAddress();
        $locationDetails = $user->getLocationDetails();
        $city = $user->getCity();
        $postalCode = $user->getPostalCode();
        $statement->bindParam(':mainAddress', $mainAddress, PDO::PARAM_STR);
        $statement->bindParam(':locationDetails', $locationDetails, PDO::PARAM_STR);
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':postalCode', $postalCode, PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getUserDetailsId(User $user): int
    {
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.users_details WHERE first_name = :firstName AND last_name = :lastName AND phone_number = :phoneNumber AND image = :image
        ');

        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $phoneNumber = $user->getPhoneNumber();
        $image = $user->getImage();
        $statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $statement->bindParam(':image', $image, PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }
}