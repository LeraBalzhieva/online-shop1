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
    protected static function getTableName(): string
    {
        return 'user_products';
    }

    public static function getAllByUserId(int $userId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();

        $results = [];
        foreach ($result as $product) {
            $results[] = static::hydrate($product);
        }
        return $results;
    }

    public static function getAllByUserIdWithProducts(int $userId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT up.*, p.id AS product_id, p.name, p.price, p.description, p.image_url 
                    FROM $tableName up 
                    INNER JOIN products p ON up.product_id=p.id 
                    WHERE user_id = :userId"
        );
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();

        $results = [];
        foreach ($result as $product) {
            $results[] = static::hydrate($product);
        }
        return $results;
    }
    public static function deleteByUserId(int $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);

    }
    public static function getByUserProducts(int $userId, int $productId): UserProduct|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
        $result = $stmt->fetch();
        if ($result) {
            return static::hydrateUserProduct($result);
        }
        return null;
    }

    public static function addUserProduct(int $userId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO  $tableName (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute([':userId' => $userId, ':productId' => $productId, ':amount' => $amount]);
    }

    public static function updateUserProduct(int $userId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute([':amount' => $amount, ':userId' => $userId, ':productId' => $productId]);
    }

    public static function deleteUserProduct(int $userId, int $productId)
    {
        $tableName = static::getTableName();
        $stmt  = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :user_id AND product_id = :productId");
        $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
    }

    public static function hydrate(array $result): self|false
    {
        if (!$result) {
            return false;
        }
        $obj = new self();
        $obj->id = $result['id'];
        $obj->userId = $result['user_id'];
        $obj->productId = $result['product_id'];
        $obj->amount = $result['amount'];

        
        $productData = [
            'id' => $result['product_id'],
            'name' => $result['name'],
            'description' => $result['description'],
            'price' => $result['price'],
            'image' => $result['image_url']

        ];
        $product = Product::hydrate($productData);
        $obj->setProduct($product);

        return $obj;
    }
    public static function hydrateUserProduct(array $result): self|false
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