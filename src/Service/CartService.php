<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }
    public function addProduct(int $productId, int $userId, int $amount)
    {
        $product = $this->userProductModel->getByUserProducts($userId, $productId);
        if (!$product) {
            $this->userProductModel->addUserProduct($userId, $productId, $amount);
        } else {
            $newAmount = $amount + $product->getAmount();
            $this->userProductModel->updateUserProduct($userId, $productId, $newAmount);
        }
    }

    public function decreaseProduct(int $productId, int $userId)
    {
        $products = $this->userProductModel->getByUserProducts($userId, $productId);

        if ($products !== null) {
            $amount = $products->getAmount();
            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateUserProduct($userId, $productId, $newAmount);
            } else {
                $this->userProductModel->deleteUserProduct($userId, $productId);
            }
        }
    }
}