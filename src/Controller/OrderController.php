<?php

namespace Controller;
use DTO\OrderCreateDTO;
use Request\OrderRequest;
use Service\OrderService;

class OrderController extends BaseController
{
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }
    public function getOrder()
    {
        require_once '../Views/order_page.php';
    }

    public function order(OrderRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: login");
            exit();
        }
        $errors = $request->validate();

        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getName(),
                $request->getPhone(),
                $request->getAddress(),
                $request->getCity(),
                $request->getComment(),
                );
            $this->orderService->create($dto);
            header("Location: /order");
            exit();
        } else {
            require_once '../Views/order_page.php';
        }
    }
    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: ../login");
            exit();
        }
        // достаем все заказы Order
        $userOrders = $this->orderService->getAll();

        require_once '../Views/order_product_page.php';
    }
}


