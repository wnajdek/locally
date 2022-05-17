<?php

class Product
{
    private $name;
    private $image;
    private $details;
    private $price;

    public function __construct($name, $image, $details, $price)
    {
        $this->name = $name;
        $this->image = $image;
        $this->details = $details;
        $this->price = $price;
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

    public function getDetails(): string
    {
        return $this->details;
    }

    public function setDetails(string $details)
    {
        $this->details = $details;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }


}