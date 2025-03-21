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
    protected function getTableName(): string
    {
        return 'reviews';
    }

    public function getReviews(int $productId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $result = $stmt->fetchAll();
        $results = [];
        foreach ($result as $product) {
            $results[] = $this->hydrate($product);
        }
        return $results;
    }
    public function getAverageRating($productId)
    {
        $stmt = $this->pdo->prepare("SELECT AVG(rating) as average_rating FROM {$this->getTableName()} WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchColumn();
    }
    public function addReview(int $productId, int $userId, int $rating, string $comment)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (product_id, user_id, rating, comment) 
                                            VALUES (:product_id, :user_id, :rating, :comment)");
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId, 'rating' => $rating, 'comment' => $comment]);
        $result = $stmt->fetch();
        return $result;
    }

    public function hydrate(array $result): self|false
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