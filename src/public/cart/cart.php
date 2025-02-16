<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (!isset($_SESSION['userId']))
    {

    header('Location: login.php');
    exit();
    } else {

    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = {$_SESSION['userId']}");
    $userProducts = $stmt->fetchAll();

    $products = [];
    foreach ($userProducts as $userProduct) {
        $productId = $userProduct['product_id'];
        $productStmt = $pdo->query("SELECT * FROM products WHERE id = $productId");
        $product = $productStmt->fetch();
        $product['amount'] = $userProduct['amount'];
        $products[] = $product;

    }
    require_once './cart/cart_page.php';
}


