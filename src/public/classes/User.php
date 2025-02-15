<?php

class User
{
    public function getRegistrate()
    {
        require_once './registration/handle_registration_form.php';
    }
    public function getLogin()
    {
        require_once './login/login_form.php';
    }
    public function getEditProfile()
    {
        require_once './editProfile/edit_profile_form.php';
    }


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
                // соединение с БД
                $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $count = $stmt->fetchColumn();
                if ($count > 0) {
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
    public function registrate()
    {
        $errors = $this->validateByUser($_POST);
// внесение в БД, если нет ошибок
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['mail'];
            $password = $_POST['psw'];
            $passwordRepeat = $_POST['psw-repeat'];
            $photo = $_POST['photo'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');

//добавление пользователей
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, image_url) VALUES (:name, :email, :password, :image_url)");
            $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, 'image_url' => $photo]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            $result = $stmt->fetch();
            print_r ($result);
        }
        require_once './registration/registration_form.php';
    }
    public function login()
    {
        $errors = $this->validateByLogin($_POST);
        // если нет ошибок, подключаемся к БД
        if (empty($errors)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $username]);
            $user = $stmt->fetch();

            if ($user === false) {
                $errors['username'] = "Логин или пароль указаны неверно!";
            } else {
                $passwordDB = $user['password'];

                if (password_verify($password, $passwordDB)) {

                    //успешный вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];

                    //успешный вход через куки
                    //setcookie('user_id', $user['id']);
                    header("Location: /catalog");
                } else {
                    $errors['username'] = "Логин или пароль указаны неверно!";
                }
            }
        }
        require_once './login/login_form.php';

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

    public function profile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {
            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
            $user = $stmt->fetch();
            require_once './profile/profile_page.php';
        } else {
            header("Location: /login/login.php");
        }
    }


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
                $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch();

                $userId = $_SESSION['userId'];
                if ($user['id'] !== $userId) {
                    $errors['email'] = "Этот Email уже зарегестрирован!";
                }
            }
        }
        return $errors;
    }
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

            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
            $user = $stmt->fetch();

            if ($user['name'] !== $name) {

                $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
                $stmt->execute([':name' => $name]);
            }

            if ($user['email'] !== $email) {

                $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = $userId");
                $stmt->execute([':email' => $email]);
            }
            header('Location: /profile');
            exit;
        }

        require_once './editProfile/edit_profile_form.php';
    }


}