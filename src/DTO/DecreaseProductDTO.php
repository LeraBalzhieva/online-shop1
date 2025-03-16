<?php

namespace DTO;

use Model\User;

class DecreaseProductDTO
{
    public function __construct(
        private string $productId,
        private User   $user,
        private int    $amount,
    )
    {
    }
    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}