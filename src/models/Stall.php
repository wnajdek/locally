<?php

class Stall
{
    private $name;
    private $likes;
    private $views;
    private $description;
    private $createdAt;
    private $image;
    private $userId;
//    private $stallTypeId;
    private $isPublic;
    private $id;

    public function __construct($name, $description, $image, $likes = 0, $views = 0, $createdAt = null,
                                $userId = null, $isPublic = false, $id = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->likes = $likes;
        $this->views = $views;
        $this->createdAt = $createdAt;
//        $this->stallTypeId = $stallTypeId;
        $this->userId = $userId;
        $this->isPublic = $isPublic;
        $this->id = $id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes($likes): void
    {
        $this->likes = $likes;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews($views): void
    {
        $this->views = $views;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

//    public function getStallTypeId(): int
//    {
//        return $this->stallTypeId;
//    }
//
//    public function setStallTypeId($stallTypeId): void
//    {
//        $this->stallTypeId = $stallTypeId;
//    }

    public function getPublic(): bool
    {
        return $this->isPublic;
    }

    public function setPublic($public): void
    {
        $this->isPublic = $public;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }



}