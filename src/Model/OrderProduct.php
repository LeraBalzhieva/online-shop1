<?php

namespace Model;
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    protected static function getTableName(): string
    {
        return 'order_products';
    }
    public static function create(int $orderId, int $productId, int $amount): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (order_id, product_id, amount) 
                                            VALUES (:orderId, :productId, :amount)");
        $stmt->execute([':orderId' => $orderId, ':productId' => $productId, ':amount' => $amount]);
    }
    public static function getAllByOrderID(int $orderId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE order_id = :orderId");
        $stmt->execute([':orderId' => $orderId]);
        $result = $stmt->fetchAll();
        $orderProducts = [];
        foreach ($result as $orderProduct) {
            $orderProducts[] = static::hydrate($orderProduct);
        }
        return $orderProducts;
    }
    public static function hydrate(array $data): self|false
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