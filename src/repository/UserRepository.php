<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User {
        $statement = $this->database->connect()->prepare("
            SELECT public.user.id user_id, email, password, enabled, created_at, user_details_id, public.role.role, first_name, last_name, phone_number, address_id, image, main_address, location_details, city, postal_code 
            FROM public.user
            INNER JOIN public.user_details ON public.user.user_details_id = user_details.id
            INNER JOIN public.address ON user_details.address_id = address.id
            INNER JOIN public.role ON public.user.role_id = public.role.id
            WHERE email LIKE :email;
        ");
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['role'],
            $user['phone_number'],
            $user['main_address'],
            $user['location_details'],
            $user['city'],
            $user['postal_code'],
            $user['image'],
            $user['user_id']
        );
    }

    public function getUserById(int $id): ?User {
        $statement = $this->database->connect()->prepare("
            SELECT public.user.id user_id, email, password, enabled, created_at, user_details_id, public.role.role, first_name, last_name, phone_number, address_id, image, main_address, location_details, city, postal_code 
            FROM public.user
            INNER JOIN public.user_details ON public.user.user_details_id = user_details.id
            INNER JOIN public.address ON user_details.address_id = address.id
            INNER JOIN public.role ON public.user.role_id = public.role.id 
            WHERE public.user.id = :id;
        ");
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['role'],
            $user['phone_number'],
            $user['main_address'],
            $user['location_details'],
            $user['city'],
            $user['postal_code'],
            $user['image'],
            $user['user_id']
        );
    }

    public function getUsers(): ?array {
        $result = [];

        $statement = $this->database->connect()->prepare('
            SELECT public.user.id user_id, email, password, enabled, created_at, user_details_id, public.role.role, first_name, last_name, phone_number, address_id, image, main_address, location_details, city, postal_code 
            FROM public.user
            INNER JOIN public.user_details ON public.user.user_details_id = user_details.id
            INNER JOIN public.address ON user_details.address_id = address.id
            INNER JOIN public.role ON public.user.role_id = public.role.id;
        ');

        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $result[] = new User(
                $user['email'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['role'],
                $user['phone_number'],
                $user['main_address'],
                $user['location_details'],
                $user['city'],
                $user['postal_code'],
                $user['image'],
                $user['user_id']
            );

        }

        return $result;
    }

    public function addUser(User $user)
    {
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.address (main_address, location_details, city, postal_code)
            VALUES (?, ?, ?, ?) RETURNING id;
        ');
        $statement->execute([
            $user->getMainAddress(),
            $user->getLocationDetails(),
            $user->getCity(),
            $user->getPostalCode()
        ]);

        $addressId = $statement->fetchColumn();

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.user_details (first_name, last_name, phone_number, address_id, image)
            VALUES (?, ?, ?, ?, ?) RETURNING id;
        ');

        $statement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhoneNumber(),
            $addressId,
            $user->getImage()
        ]);

        $userDetailsId = $statement->fetchColumn();


        $statement = $this->database->connect()->prepare('
            INSERT INTO public.user (email, password, enabled, created_at, user_details_id, role_id)
            VALUES (?, ?, ?, ?, ? ,? ,?)
        ');

        $enabled = true;
        $createdAt = new DateTime();
        $createdAtString = date_format($createdAt,"Y/m/d H:i:s");
        $roleId = 1; // user


        $statement->execute([
            $user->getEmail(),
            $user->getPassword(),
            $enabled,
            $createdAtString,
            $userDetailsId,
            $roleId
        ]);
    }

    public function updateUser(User $user) {
        $statement = $this->database->connect()->prepare(
            'UPDATE public.user 
            SET password = ?,
                enabled = ?,
                salt = ?
            WHERE id = ?
            returning user_details_id'
        );

        $statement->execute([
            $user->getPassword(),
            true,
            1,
            $user->getId()
        ]);

        $userDetailsId = $statement->fetchColumn();

        $statement = $this->database->connect()->prepare(
            'UPDATE public.user_details
            SET first_name = ?,
                last_name = ?,
                phone_number = ?
            WHERE public.user_details.id = ?
                  returning address_id'
        );

        $statement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhoneNumber(),
            $userDetailsId
        ]);

        $addressId = $statement->fetchColumn();

        $statement = $this->database->connect()->prepare(
            'UPDATE public.address
            SET main_address = ?,
                location_details = ?,
                city = ?,
                postal_code = ?
            WHERE public.address.id = ?'
        );

        $statement->execute([
            $user->getMainAddress(),
            $user->getLocationDetails(),
            $user->getCity(),
            $user->getPostalCode(),
            $addressId
        ]);
    }

    public function deleteUser(int $id) {
        $statement = $this->database->connect()->prepare(
            'DELETE FROM public.user
                    WHERE id = ?'
        );

        $statement->execute([
            $id
        ]);
    }

    public function getLikedStallsIds(int $id) {

        $statement = $this->database->connect()->prepare('
            SELECT stall_id FROM public.user_favourite_stalls WHERE user_id = :id
        ');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getStallId(int $id): int {
        $statement = $this->database->connect()->prepare('
            SELECT public.stall.id FROM public.stall WHERE user_id = :id
        ');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchColumn();
    }
}