<?php

namespace Model;

class UserProduct extends Model
{
    public function getByUserProduct(int $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function deleteProduct(int $userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);

    }

}