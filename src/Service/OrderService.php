<?php

namespace Service;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
    }

    public function order(int $userId, int $orderId): void
    {
        $userProducts = $this->userProductModel->getAllByUserId($userId);
        foreach ($userProducts as $userProduct) {

            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();
            $this->orderProductModel->create($productId, $orderId, $amount);
        }
        $this->userProductModel->deleteByUserId($userId);
    }
}