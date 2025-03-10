<?php

namespace Model;
class OrderProduct extends Model
{
    private int $id;
    private int $productId;
    private int $orderId;
    private int $amount;
    private Product $product;

    public function create(int $productId, int $orderId, int $amount): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (product_id, order_id, amount) VALUES (:productId, :orderId, :amount)");
        $stmt->execute([':productId' => $productId, ':orderId' => $orderId, ':amount' => $amount]);
    }

    public function getAllByOrderID(int $orderId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM order_products WHERE order_id = :orderId');
        $stmt->execute([':orderId' => $orderId]);
        $result = $stmt->fetchAll();
        $orderProducts = [];
        foreach ($result as $orderProduct) {
            $orderProducts[] = $this->hydrate($orderProduct);
        }
        return $orderProducts;
    }


    public function hydrate(array $data): self|false
    {
        if (!$data) {
            return false;
        }
        $obj = new self();
        $obj->id = $data['id'];
        $obj->productId = $data['product_id'];
        $obj->orderId = $data['order_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getProductId()
    {
        return $this->productId;
    }


    public function getAmount()
    {
        return $this->amount;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }


}