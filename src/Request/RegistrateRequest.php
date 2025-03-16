<?php

namespace Request;

use Model\User;
class RegistrateRequest
{
    private User $userModel;
    public function __construct(private array $data)
    {
        $this->userModel = new User;

    }
    public function getName(): string
    {
        return $this->data['name'];
    }
    public function getEmail(): string
    {
        return $this->data['mail'];
    }
    public function getPassword(): string
    {
        return $this->data['psw'];
    }
    public function getPhoto(): string
    {
        return $this->data['photo'];

    }
    // Валидация изера при регистрации
    public function validate(): array
    {
        $errors = [];
// объявление и валидация данных
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($this->data['mail'])) {
            $email = $this->data['mail'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {


                $user = $this->userModel->getByEmail($email);

                if ($user === false) {
                    $errors['email'] = "Этот Email уже зарегестрирован!";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен";
        }
// проверка совпадения паролей
        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (strlen($password) < 3) {
                $errors['psw'] = "Пароль не может содержать меньше 3 символов";
            }
            $passwordRepeat = $this->data["psw-repeat"];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают!";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен!";
        }
        return $errors;
    }


}