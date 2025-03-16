<?php

namespace Request;

class OrderRequest
{
    public function __construct(private array $data)
    {

    }
    public function getName() : string
    {
        return $this->data['name'];
    }
    public function getPhone() : string
    {
        return $this->data['phone'];
    }
    public function getCity() : string
    {
        return $this->data['city'];
    }
    public function getAddress() : string
    {
        return $this->data['address'];
    }
    public function getComment() : string
    {
        return $this->data['comment'];
    }
    public function getUserId() : int
    {
        return $this->data['userId'];
    }
    public function validate(): array
    {
        $errors = [];
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($this->data['phone'])) {
            $phone = $this->data['phone'];
            if (strlen($phone < 5)) {
                $errors['phone'] = "Введите корректный номер телефона";
            }
        } else {
            $errors['phone'] = "Поле должно быть заполнено";
        }

        if (isset($this->data['city'])) {
            $city = $this->data['city'];
            if (strlen($city) < 3) {
                $errors['city'] = "Введите правильный город";
            }
        } else {
            $errors['city'] = "Поле должно быть заполнено";
        }

        if (isset($this->data['address'])) {
            $address = $this->data['address'];
            if (strlen($address) < 3) {
                $errors['address'] = "Введите правильный адрес";
            }
        } else {
            $errors['address'] = "Поле должно быть заполнено";
        }
        return $errors;
    }

}