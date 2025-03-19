<?php

namespace Model;
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    protected function getTableName(): string
    {
        return 'order_products';
    }
    public function create(int $orderId, int $productId, int $amount): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (order_id, product_id, amount) 
                                            VALUES (:orderId, :productId, :amount)");
        $stmt->execute([':orderId' => $orderId, ':productId' => $productId, ':amount' => $amount]);
    }
    public function getAllByOrderID(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE order_id = :orderId");
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