<?php

class Address {
    private $mainAddress;
    private $locationDetails;
    private $city;
    private $postalCode;

    public function __construct()
    {

    }

    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    public function setMainAddress($mainAddress): void
    {
        $this->mainAddress = $mainAddress;
    }

    public function getLocationDetails()
    {
        return $this->locationDetails;
    }

    public function setLocationDetails($locationDetails): void
    {
        $this->locationDetails = $locationDetails;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }



}