<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header('Location: ../login.php');
    exit;
}
function validate(array $data): array
{
    $errors = [];

// объявление и валидация данных
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

$errors = validate($_POST);

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