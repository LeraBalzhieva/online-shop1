<?php

namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private float $amount;
    private Product $product;
    private int $total;
    protected function getTableName(): string
    {
        return 'user_products';
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();

        $results = [];
        foreach ($result as $product) {
            $results[] = $this->hydrate($product);
        }
        return $results;
    }

    public function deleteByUserId(int $userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);

    }

    public function getByUserProducts(int $userId, int $productId): UserProduct|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
        $result = $stmt->fetch();
        if ($result) {
            return $this->hydrate($result);
        }
        return null;
    }

    public function addUserProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute([':userId' => $userId, ':productId' => $productId, ':amount' => $amount]);
    }

    public function updateUserProduct(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute([':amount' => $amount, ':userId' => $userId, ':productId' => $productId]);
    }

    public function deleteUserProduct(int $userId, int $productId)
    {
        $stmt  = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
    }

    public function hydrate(array $result): self|false
    {
        if (!$result) {
            return false;
        }
        $obj = new self();
        $obj->id = $result['id'];
        $obj->userId = $result['user_id'];
        $obj->productId = $result['product_id'];
        $obj->amount = $result['amount'];

        return $obj;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }


    public function getProductId():int
    {
        return $this->productId;
    }


    public function getAmount(): int
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

    public function getTotal(): int
    {
        return $this->total;
    }
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }











}