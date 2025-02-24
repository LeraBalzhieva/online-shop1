<?php

namespace Model;

//use Model;

class OrderProduct extends Model

{
    public function create(int $productId, int $orderId, int $amount): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (product_id, order_id, amount) VALUES (:productId, :orderId, :amount)");
        $stmt->execute([':productId' => $productId, ':orderId' => $orderId, ':amount' => $amount]);
    }



}