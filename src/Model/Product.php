<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private string $image;

    private int $total;

    public function getByCatalog(): array|null
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        $newProducts = [];
        foreach ($products as $product) {
            $newProducts[] = $this->hydrate($product);
        }
        return $newProducts;
    }
    private function hydrate($products): self|null
    {
        if (!$products) {
            return null;
        }
        $obj = new self();
        $obj->id = $products["id"];
        $obj->name = $products["name"];
        $obj->price = $products["price"];
        $obj->description = $products["description"];
        $obj->image = $products["image_url"];
        return $obj;
    }
    public function getByProduct(int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch();

        return $this->hydrate($result);

    }
    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // Сеттер для цены
    public function setPrice($price)
    {
        $this->price = $price;
    }

    // Сеттер для общей суммы
    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal() {
        return $this->total;
    }



}