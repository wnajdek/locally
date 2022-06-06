<?php

class User {
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $mainAddress;
    private string $locationDetails;
    private string $city;
    private string $postalCode;
    private string $image;

    public function __construct(string $email, string $password, string $firstName, string $lastName)
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getMainAddress(): string
    {
        return $this->mainAddress;
    }

    public function setMainAddress(string $mainAddress): void
    {
        $this->mainAddress = $mainAddress;
    }

    public function getLocationDetails(): string
    {
        return $this->locationDetails;
    }

    public function setLocationDetails(string $locationDetails): void
    {
        $this->locationDetails = $locationDetails;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }



}