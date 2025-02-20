<?php

namespace Model;

class Product extends Model
{
    public function getByCatalog(int $productId): array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getByUserProducts(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addUserProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute([':userId' => $userId, ':productId' => $productId, ':amount' => $amount]);
    }

    public function updateUserProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute([':amount' => $amount, ':userId' => $userId, ':productId' => $productId]);
    }

    public function getByProduct(int $productId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }
}