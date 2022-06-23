<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Stall.php';

class StallRepository extends Repository
{
    public function getStall(int $id): ?Stall {
        $statement = $this->database->connect()->prepare(
            "SELECT * FROM public.stall WHERE id = :id"
        );
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $stall = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$stall) {
            return null;
        }

        return new Stall(
            $stall['name'],
            $stall['description'],
            $stall['image'],
            $stall['likes'],
            $stall['views'],
            $stall['created_at'],
            $stall['stall_type_id'],
            $stall['user_id'],
            $stall['is_public'],
            $stall['id']
        );
    }

    public function addStall(Stall $stall): void {

        $statement = $this->database->connect()->prepare(
            'INSERT INTO public.stall ("name", likes, views, description, user_id, stall_type_id, image)
            VALUES (?, ?, ?, ?, ?, ?, ?)'
        );

        $stall_type_id = 1;

        $statement->execute([
            $stall->getName(),
            $stall->getLikes(),
            $stall->getViews(),
            $stall->getDescription(),
            $stall->getUserId(),
            $stall_type_id,
            $stall->getImage()
        ]);
    }

    public function getStallByName(string $value) {
        $value = strtolower('%' . $value . '%');

        $statement = $this->database->connect()->prepare('
            SELECT stall.* FROM public.stall WHERE LOWER(name) LIKE :value AND is_public
        ');

        $statement->bindParam(':value', $value, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStallByCategory(string $value) {
        $value = strtolower('%' . $value . '%');

        $statement = $this->database->connect()->prepare('
            SELECT stall.* FROM public.stall 
            INNER JOIN public.stall_type ON stall.stall_type_id = stall_type.id
            WHERE LOWER(public.stall_type.type) LIKE :value AND is_public;
        ');

        $statement->bindParam(':value', $value, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStallByProductName(string $value) {
        $value = strtolower('%' . $value . '%');

        $statement = $this->database->connect()->prepare('
            SELECT DISTINCT stall.* FROM public.stall 
            INNER JOIN public.product ON stall.id = product.stall_id
            WHERE LOWER(public.product.name) LIKE :value AND is_public;
        ');

        $statement->bindParam(':value', $value, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserId(User $user): int
    {
        // TODO: get currently logged in user
        return -1;
    }

    public function getStallByUserId(int $id): ?Stall {
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.stall
            WHERE user_id = :userId;
        ');

        $statement->bindParam(':userId', $id, PDO::PARAM_INT);
        $statement->execute();

        $stall = $statement->fetch(PDO::FETCH_ASSOC);

        return new Stall(
            $stall['name'],
            $stall['description'],
            $stall['image'],
            $stall['likes'],
            $stall['views'],
            $stall['created_at'],
            $stall['stall_type_id'],
            $stall['user_id'],
            $stall['is_public'],
            $stall['id']
        );
    }

    public function getStalls(): ?array {
        $result = [];

        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.stall WHERE is_public
        ');

        $statement->execute();
        $stalls = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stalls as $stall) {
            $result[] = new Stall(
                $stall['name'],
                $stall['description'],
                $stall['image'],
                $stall['likes'],
                $stall['views'],
                $stall['created_at'],
                $stall['stall_type_id'],
                $stall['user_id'],
                $stall['is_public'],
                $stall['id']
            );

        }

        return $result;
    }

    public function like(int $id, int $userId) {
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.user_favourite_stalls (user_id, stall_id)
            VALUES (?, ?);
        ');

        $statement->execute([$userId, $id]);


        $statement = $this->database->connect()->prepare('
            UPDATE stall SET likes = likes + 1 WHERE id = :id
        ');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function dislike(int $id, int $userId) {

        $statement = $this->database->connect()->prepare('
            DELETE FROM public.user_favourite_stalls
                   WHERE user_id = ? AND stall_id = ?;
        ');

        $statement->execute([$userId, $id]);

        $statement = $this->database->connect()->prepare('
            UPDATE stall SET likes = likes - 1 WHERE id = :id
        ');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}