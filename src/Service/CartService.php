<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private AuthInterface $authService;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->authService = new AuthSessionService();
    }
    public function addProduct(AddProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();
        $amount = 1;
        $product = $this->userProductModel->getByUserProducts($userId, $data->getProductId());
        if (!$product) {
            $this->userProductModel->addUserProduct($userId, $data->getProductId(), $amount);
        } else {
            $newAmount = $amount + $product->getAmount();
            $this->userProductModel->updateUserProduct($userId, $data->getProductId(), $newAmount);
        }
    }
    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();
        $products = $this->userProductModel->getByUserProducts($userId, $data->getProductId());

        if ($products !== null) {
            $amount = $products->getAmount();
            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateUserProduct($userId, $data->getProductId(), $newAmount);
            } else {
                $this->userProductModel->deleteUserProduct($userId, $data->getProductId());
            }
        }
    }
    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();
        if ($user === null) {
            return [];
        }
        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());

        $total = 0;

        foreach ($userProducts as $userProduct) {
            $product = $this->productModel->getByProduct($userProduct->getProductId());
            $userProduct->setProduct($product);
            $total += $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotal($total);
        }
        return $userProducts;
    }
    public function getSum(): int
    {
        $total = 0;
        foreach ($this->getUserProducts() as $userProduct) {
            $total += $userProduct->getTotal();
        }
        return $total;
    }

}