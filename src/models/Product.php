<?php

class Product
{
    private $name;
    private $image;
    private $description;
    private $price;
    private $productTypeId;
    private $stallId;
    private $id;

    public function __construct($name, $description, $price, $image, $productTypeId, $stallId, $id = null)
    {
        $this->name = $name;
        $this->image = $image;
        $this->description = $description;
        $this->price = $price;
        $this->productTypeId = $productTypeId;
        $this->stallId = $stallId;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getProductTypeId(): int
    {
        return $this->productTypeId;
    }

    public function setProductTypeId($productTypeId): void
    {
        $this->productTypeId = $productTypeId;
    }

    public function getStallId(): int
    {
        return $this->stallId;
    }

    public function setStallId($stallId): void
    {
        $this->stallId = $stallId;
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