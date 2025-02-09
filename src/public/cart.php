<?php

session_start();

if (isset($_SESSION['userId'])) {
    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->query('SELECT * FROM user_products WHERE user_id = ' . $_SESSION['userId']);


    $products = $stmt->fetchAll();
    require_once './cart_page.php';
} else {
    echo "Error";
}



