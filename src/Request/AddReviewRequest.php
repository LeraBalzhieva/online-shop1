<?php

namespace Request;

class AddReviewRequest
{
    public function __construct(private array $data)
    {

    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getRating(): int
    {
        return $this->data['rating'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }

    public function validate(): array
    {
        $errors = [];
        if (isset($this->data['comment'])) {
            $reviewComment = $this->data['comment'];
            if (strlen($reviewComment) < 2 || strlen($reviewComment) > 255) {
                $errors['comment'] = 'Длина строки должна быть больше 2 и меньше 255';
            }
        }
        if (isset($this->data['rating'])) {
            $reviewRating = (int)$this->data['rating'];
            if ($reviewRating < 1 || $reviewRating > 5) {
                $errors['rating'] = 'Длина строки должна быть больше 2 и меньше 255';
            }
        }
        return $errors;
    }

}