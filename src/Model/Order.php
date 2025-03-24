<?php

namespace Model;


class Order extends Model
{
    private int $id;
    private string $name;
    private string $address;
    private string $city;
    private string $phone;
    private string $comment;
    private int $userId;
    private int $total;
    private array $orderProducts;

    protected static function getTableName(): string
    {
        return 'orders';
    }

    public static function create(string $name, string $phone, string $city, string $address, string $comment, int $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO $tableName (name, phone, city, address, comment, user_id)
                    VALUES (:name, :phone, :city, :address, :comment, :user_id) RETURNING id"
        );
        $stmt->execute([
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'phone' => $phone,
            'comment' => $comment,
            'user_id' => $userId
        ]);
        $result = $stmt->fetch();
        return $result['id'];
    }

    public static function getAllByUserId(int $userId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);
        $orders = $stmt->fetchAll();
        $newOrder = [];
        foreach ($orders as $order) {
            $newOrder[] = static::hydrate($order);
        }
        return $newOrder;
    }

    public function getAllByUserIdWithProducts(int $userId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("
                                    SELECT *
                                    FROM $tableName o 
                                    INNER JOIN order_products op ON o.id = op.order_id 
                                    INNER JOIN products p ON op.product_id = p.id 
                                    WHERE o.user_id = :userId
    ");
        $stmt->execute(['userId' => $userId]);
        $orders = $stmt->fetchAll();
        $newOrder = [];
        foreach ($orders as $order) {
            $newOrder[] = $this->hydrate($order);
        }
        return $newOrder;
    }


    public static function hydrate($orders): self|null
    {
        if (!$orders) {
            return null;
        }
        $obj = new self();
        $obj->id = $orders['id'];
        $obj->name = $orders['name'];
        $obj->address = $orders['address'];
        $obj->city = $orders['city'];
        $obj->phone = $orders['phone'];
        $obj->comment = $orders['comment'];
        $obj->userId = $orders['user_id'];
        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function setOrderProducts(array $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
    }


}