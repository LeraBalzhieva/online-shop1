<?php

namespace Service;
use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
    }

    public function create(OrderCreateDTO $data): void
    {
        $userProducts = $this->userProductModel->getAllByUserId($data->getUser()->getId());
        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getCity(),
            $data->getAddress(),
            $data->getComment(),
            $data->getUser()->getId()
        );
        foreach ($userProducts as $userProduct) {

            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();
            $this->orderProductModel->create($productId, $orderId, $amount);
        }
        $this->userProductModel->deleteByUserId($data->getUser()->getId());
    }
}