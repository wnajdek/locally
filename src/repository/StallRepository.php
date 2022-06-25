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
            $stall['user_id'],
            $stall['is_public'],
            $stall['id']
        );
    }

    public function addStall(Stall $stall): void {

        $statement = $this->database->connect()->prepare(
            'INSERT INTO public.stall ("name", likes, views, description, user_id, image)
            VALUES (?, ?, ?, ?, ?, ?)'
        );

        $statement->execute([
            $stall->getName(),
            $stall->getLikes(),
            $stall->getViews(),
            $stall->getDescription(),
            $stall->getUserId(),
            $stall->getImage()
        ]);
    }

    public function updateStall(Stall $stall): void {

        $statement = $this->database->connect()->prepare(
            'UPDATE public.stall 
            SET "name" = ?,
                likes = ?,
                views = ?,
                description = ?,
                user_id = ?,
                image = ?,
                is_public = ?
            WHERE id = ?'
        );

        $statement->execute([
            $stall->getName(),
            $stall->getLikes(),
            $stall->getViews(),
            $stall->getDescription(),
            $stall->getUserId(),
            $stall->getImage(),
            (int) $stall->getPublic(),
            $stall->getId()
        ]);
    }

    public function getStallByName(string $value) {
        $value = strtolower('%' . $value . '%');

        $statement = $this->database->connect()->prepare('
            SELECT DISTINCT stall.* FROM public.stall WHERE LOWER(name) LIKE :value AND is_public
        ');

        $statement->bindParam(':value', $value, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStallByCategory(string $value) {
        $value = strtolower('%' . $value . '%');

        $statement = $this->database->connect()->prepare('
            SELECT DISTINCT stall.* FROM public.stall 
            INNER JOIN public.stall_types_stall ON stall.id = stall_types_stall.stall_id
            INNER JOIN public.stall_type ON stall_type.id = stall_types_stall.stall_type_id
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
                $stall['user_id'],
                $stall['is_public'],
                $stall['id']
            );

        }

        return $result;
    }

    public function getCategoriesByStallId(int $stallId): ?array {
        $statement = $this->database->connect()->prepare('
            SELECT DISTINCT stall_type.* FROM public.stall
            INNER JOIN public.stall_types_stall ON stall.id = stall_types_stall.stall_id
            INNER JOIN public.stall_type ON stall_type.id = stall_types_stall.stall_type_id
            WHERE stall_id = :id;
        ');

        $statement->execute(['id' => $stallId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory(int $categoryId, int $stallId): void {
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.stall_types_stall WHERE stall_id = ? AND stall_type_id = ?;
        ');

        $statement->execute([$stallId, $categoryId]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return;
        }

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.stall_types_stall (stall_id, stall_type_id)
            VALUES (?, ?);
        ');

        $statement->execute([$stallId, $categoryId]);
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