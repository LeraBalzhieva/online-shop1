<?php

class UserController
{
    public function getRegistrate()
    {
        require_once '../Views/registration_form.php';
    }

    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }
    public function getProfile()
    {
        require_once '../Views/profile_page.php';
    }

    public function getEditProfile()
    {
        require_once '../Views/edit_profile_form.php';
    }

    //Регистрация
    public function registrate()
    {
        $errors = $this->validateByUser($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['mail'];
            $password = $_POST['psw'];
            $passwordRepeat = $_POST['psw-repeat'];
            $photo = $_POST['photo'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            //добавление данных и
            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->addUser($name, $email, $password, $photo);
            $user = $userModel->getByEmail($email);
        }
        require_once '../Views/registration_form.php';
    }
    // Валидация изера при регистрации
    private function validateByUser(array $data): array
    {
        $errors = [];
// объявление и валидация данных
        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($data['mail'])) {
            $email = $data['mail'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {

                require_once '../Model/User.php';
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                if ($user !== false) {
                    $errors['email'] = "Этот Email уже зарегестрирован!";
                }
            }
        } else {
            $errors['email'] = "Email должен быть заполнен";
        }
// проверка совпадения паролей
        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 3) {
                $errors['psw'] = "Пароль не может содержать меньше 3 символов";
            }
            $passwordRepeat = $data["psw-repeat"];
            if ($password !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают!";
            }
        } else {
            $errors['psw'] = "Пароль должен быть заполнен!";
        }
        return $errors;
    }

    public function login()
    {
        $errors = $this->validateByLogin($_POST);
        // если нет ошибок, подключаемся к БД
        if (empty($errors)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            //проверка уникальности пароля
            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->getByEmail($username);

            if ($user === false) {
                $errors['username'] = "Логин или пароль указаны неверно!";
            } else {
                $passwordDB = $user['password'];

                if (password_verify($password, $passwordDB)) {
                    //успешный вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];
                    header("Location: /catalog");
                } else {
                    $errors['username'] = "Логин или пароль указаны неверно!";
                }
            }
        }
        require_once '../Views/login_form.php';
    }

    private function validateByLogin(array $data): array
    {
        $errors = [];
        // проверка наличия переменных
        if (isset($date['username'])) {
            $errors['username'] = "Поле Username обязательно для заполнения!";
        }
        if (isset($date['password'])) {
            $errors['password'] = "Поле Password обязательно для заполнения!";
        }
        return $errors;
    }

    //выдача профиля
    public function profile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {

            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->verification($_SESSION['userId']);

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login/login.php");
        }
    }
    //валиядация при изменении профиля
    private function validateProfile(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        }
        if (isset($data['mail'])) {
            $email = $data['mail'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {
                require_once '../Model/User.php';
                $userModel = new User();
                $user = $userModel->getByEmail($email);


                $userId = $_SESSION['userId'];
                if ($user['id'] !== $userId) {
                    $errors['email'] = "Этот Email уже зарегестрирован!";
                }
            }
        }
        return $errors;
    }
// изменение данных на странице профиля
    public function editProfile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: ../login.php');
            exit;
        }

        $errors = $this->validateProfile($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['mail'];
            $userId = $_SESSION['userId'];

            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->verification($_SESSION['userId']);

            if ($user['name'] !== $name) {
                $userModel->updateNamedByID($name, $userId);
            }

            if ($user['email'] !== $email) {

                $userModel->updateEmailByID($email, $userId);
            }
            header('Location: /profile');
            exit;
        }

        require_once '../Views/edit_profile_form.php';
    }


}