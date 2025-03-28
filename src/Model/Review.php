<?php

namespace Model;
class Review extends Model
{
    private int $id;
    private int $productId;
    private int $userId;
    private int $rating;
    private string $comment;
    private $createdAt;
    protected static function getTableName(): string
    {
        return 'reviews';
    }

    public static function getReviews(int $productId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $result = $stmt->fetchAll();
        $results = [];
        foreach ($result as $product) {
            $results[] = static::hydrate($product);
        }
        return $results;
    }
    public static function getAverageRating($productId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT AVG(rating) as average_rating FROM $tableName WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchColumn();
    }
    public static function addReview(int $productId, int $userId, int $rating, string $comment)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (product_id, user_id, rating, comment) 
                                            VALUES (:product_id, :user_id, :rating, :comment)");
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId, 'rating' => $rating, 'comment' => $comment]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function hydrate(array $result): self|false
    {
        if (!$result) {
            return false;
        }
        $obj = new self();
        $obj->id = $result['id'];
        $obj->productId = $result['product_id'];
        $obj->userId = $result['user_id'];
        $obj->rating = $result['rating'];
        $obj->comment = $result['comment'];
        $obj->createdAt = $result['created_at'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }




}