<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
    //если пользователь найден, выдаем каталог
    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll();
    require_once './catalog/catalog_page.php';
} else {
    header("Location: /login/login");
}


