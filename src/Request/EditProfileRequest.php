<?php

namespace Request;

use Model\User;

class EditProfileRequest
{
    private User $userModel;

    public function __construct(private array $data)
    {
        $this->userModel = new User();
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['mail'];
    }

    //валидация при изменении профиля
    public function validate(): array
    {
        $errors = [];

        // Проверка имени
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        } else {
            $errors['name'] = 'Заполните поле';
        }

        // Проверка email только если он установлен
        if (isset($this->data['mail'])) {
            $email = $this->data['mail'];
            if (strlen($email) < 7) {
                $errors['email'] = "Email не может содержать меньше 7 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {
                $user = $this->userModel->getByEmail($email);
                if ($user) {
                    $errors['email'] = "Этот Email уже зарегистрирован!";
                }
            }
        }

        return $errors;
    }
}

