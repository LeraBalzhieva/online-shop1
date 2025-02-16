<?php

class Product
{
    public function getByCatalog(int $productId): array|false
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        //если пользователь найден, выдаем каталог
        $stmt = $pdo->query('SELECT * FROM products');
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getByUserProducts(int $userId, int $productId): array
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }
    public function addUserProduct(int $userId, int $productId, int $amount): array
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute([':userId' => $userId, ':productId' => $productId, ':amount' => $amount]);

    }

    public function updateUserProduct(int $userId, int $productId, int $amount)
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute([':amount' => $amount, ':userId' => $userId, ':productId' => $productId]);
    }
    public function getByProduct(int $productId): array
    {
        $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }


}