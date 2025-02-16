<?php

class Cart
{
    public function getByUserProducts(int $userId)
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = {$_SESSION['userId']}");
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getByProduct(int $productId)
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $productStmt = $pdo->query("SELECT * FROM products WHERE id = $productId");
        $result = $productStmt->fetch();
        return $result;
    }



}