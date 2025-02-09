<?php

function validate(array $data): array
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

    return $errors;
}

$errors = validate($_POST);

if (empty($errors)) {
    session_start();
    $name = $_POST['name'];
    $email = $_POST['mail'];

    if (isset($_SESSION['userId'])) {

        $userId = $_SESSION['userId'];

        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
        $users = $stmt->fetch();

        if ($users['name'] !== $name) {
            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
            $stmt->execute([':name' => $name]);
            echo "Новое имя: " . $name;
        }

        if ($users['email'] !== $email) {
            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = $userId");
            $stmt->execute([':email' => $email]);
            echo "Новый email: " . $email;
        } else {
            http_response_code(404);
            require_once './404.php';
        }
    } else {
        echo "NO";
    }
}



require_once './profile_form.php';