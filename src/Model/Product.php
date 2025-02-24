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

    public function getByProduct(int $productId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }
}