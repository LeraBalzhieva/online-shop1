<?php

namespace DTO;

use Model\User;

class OrderCreateDTO
{
    public function __construct(
        private string $name,
        private string $phone,
        private string $city,
        private string $address,
        private string $comment
    ){
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}