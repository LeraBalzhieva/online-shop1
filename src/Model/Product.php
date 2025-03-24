<?php
namespace Model;
class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private $image;
    private int $total;
    public static function getTableName(): string
    {
        return 'products';
    }
    public static function getByCatalog(): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName");
        $products = $stmt->fetchAll();
        $newProducts = [];
        foreach ($products as $product) {
            $newProducts[] = static::hydrate($product);
        }
        return $newProducts;
    }

    public static function getByProduct(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch();
        return static::hydrate($result);
    }

    public static function hydrate($products): self|null
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