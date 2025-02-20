<?php

namespace Model;

use Model;

class OrderProduct extends Model

{
    public function addOrderProduct(int $productId, int $orderId, int $count): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_product (product_id, order_id, quantity) VALUES (:productId, :orderId, :quantity)");
        $stmt->execute([':productId' => $productId, ':orderId' => $orderId, ':quantity' => $count]);

    }

}