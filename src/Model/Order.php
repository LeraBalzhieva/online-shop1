<?php

require_once './src/Model/Model.php';
class Order extends Model
{
    public function addOrder(string $name, string $email, string $address, string $city, string $phone): array|false
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, address, city, phone) VALUES (:name, :email, :address, :city, :phone)");
        $stmt->execute([':name' => $name, ':email' => $email, ':address' => $address, ':city' => $city, ':phone' => $phone]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getOrderId(): int|null
    {
        return $this->pdo->lastInsertId();
    }

}