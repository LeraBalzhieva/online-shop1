<?php

namespace Request;

class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getUsername(): string
    {
        return $this->data['username'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function validate(): array
    {
        $errors = [];
        // проверка наличия переменных
        if (isset($this->date['username'])) {
            $errors['username'] = "Поле Username обязательно для заполнения!";
        }
        if (isset($this->date['password'])) {
            $errors['password'] = "Поле Password обязательно для заполнения!";
        }
        return $errors;
    }

}