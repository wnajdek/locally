<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User {
        $statement = $this->database->connect()->prepare("
            SELECT public.user.id user_id, email, password, enabled, salt, created_at, user_details_id, role_id, first_name, last_name, phone_number, address_id, image, main_address, location_details, city, postal_code 
            FROM public.user
            INNER JOIN public.user_details ON public.user.user_details_id = user_details.id
            INNER JOIN public.address ON user_details.address_id = address.id
            WHERE email LIKE :email;
        ");
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

//        $statement = $this->database->connect()->prepare(
//            "SELECT * FROM public.user_details WHERE id = :userDetailsId"
//        );
//
//        $userDetailsId = $user['user_details_id'];
//        $statement->bindParam(':userDetailsId',$userDetailsId, PDO::PARAM_INT);
//        $statement->execute();
//
//        $userDetails = $statement->fetch(PDO::FETCH_ASSOC);

//        $firstName = $userDetails['first_name'];
//        $lastName = $userDetails['last_name'];

        return new User(
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['phone_number'],
            $user['main_address'],
            $user['location_details'],
            $user['city'],
            $user['postal_code'],
            $user['image'],
            $user['user_id']
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
            INSERT INTO public.user_details (first_name, last_name, phone_number, address_id, image)
            VALUES (?, ?, ?, ?, ?)
        ');

        $statement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhoneNumber(),
            $this->getAddressId($user),
            $user->getImage()
        ]);

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.user (email, password, enabled, salt, created_at, user_details_id, role_id)
            VALUES (?, ?, ?, ?, ? ,? ,?)
        ');

        $enabled = true;
        $salt = 1;
        $createdAt = new DateTime();
        $createdAtString = date_format($createdAt,"Y/m/d H:i:s");
        $roleId = 1;


        $statement->execute([
            $user->getEmail(),
            $user->getPassword(),
            $enabled,
            $salt,
            $createdAtString,
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
            SELECT * FROM public.user_details WHERE first_name = :firstName AND last_name = :lastName AND phone_number = :phoneNumber AND image = :image
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