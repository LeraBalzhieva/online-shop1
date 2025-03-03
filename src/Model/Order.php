<?php

namespace Model;


class Order extends Model
{
    public function addOrder(string $name,  string $address, string $city, string $phone, int $userId, string $comment)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (name, address, city, phone, user_id, comment)
                    VALUES (:name, :address, :city, :phone, :user_id, :comment) RETURNING id"
        );
        $stmt->execute([
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'phone' => $phone,
            'user_id' => $userId,
            'comment' => $comment
        ]);
        $result = $stmt->fetch();
        return $result['id'];
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

}