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


    public function addOrder(string $name,  string $phone, string $city,  string $address, int $userId, string $comment)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (name, phone, city, address, user_id, comment)
                    VALUES (:name, :phone, :city, :address, :user_id, :comment) RETURNING id"
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

    public function getAllByUserId(int $userId): array|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $orders = $stmt->fetchAll();
        $newOrder = [];
        foreach ($orders as $order) {
            $newOrder[] = $this->hydrate($order);
        }
        return $newOrder;

    }

    private function hydrate($orders): self|null
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