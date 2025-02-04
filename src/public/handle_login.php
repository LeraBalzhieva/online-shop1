<?php

$errors = [];

// проверка наличия переменный
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    // разделить
    $password = $_POST["password"];
    if (empty($username)) {
        $errors['username'] = "Поле Username обязательно для заполнения!";
    }
    if (empty($password)) {
        $errors['password'] = "Поле Password обязательно для заполнения!";
    }
    // если нет ошибок, подключаемся к БД
    if (empty($errors)) {
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
                $_SESSION['userName'] = $user['name'];

                //успешный вход через куки
                //setcookie('user_id', $user['id']);
                header("Location: /catalog.php");

            } else {
                $errors['username'] = "Логин или пароль указаны неверно!";
            }
        }

    }

} else {
    $errors[] = "Заполните форму для ввода";
}

require_once './login_form.php';
