<?php

namespace Service;
use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private Product $productModel;
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }
    public function create(OrderCreateDTO $data)
    {
        $sum = $this->cartService->getSum();
        if ($sum < 500)
        {
            throw new \Exception('Для оформления заказа сумма корзины должна быть больше 500р');
        }
        $user = $this->authService->getCurrentUser();
        $userProducts = $this->userProductModel->getAllByUserId($user->getId());

        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getCity(),
            $data->getAddress(),
            $data->getComment(),
            $user->getId()
        );
        foreach ($userProducts as $userProduct) {

            $this->orderProductModel->create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
        }
        $this->userProductModel->deleteByUserId($user->getId());
    }

    public function getAll(): array
    {
        $user = $this->authService->getCurrentUser();

        $orders = $this->orderModel->getAllByUserId($user->getId());

        foreach ($orders as $userOrder) {
            // достаем продукты в заказах orderProduct по orderId
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());

            $totalSum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getByProduct($orderProduct->getProductId());
                $orderProduct->setProduct($product);
                $totalSum += $orderProduct->getAmount() * $product->getPrice();

            }
            $userOrder->setOrderProducts($orderProducts);
            $userOrder->setTotal($totalSum);
        }
        return $orders;
    }

}