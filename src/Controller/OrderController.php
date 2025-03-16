<?php

namespace Controller;
use DTO\OrderCreateDTO;
use Model\OrderProduct;
use Model\Order;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\OrderService;

class OrderController extends BaseController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
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

            $user = $this->authService->getCurrentUser();
            $dto = new OrderCreateDTO(
                $request['name'],
                $request['phone'],
                $request['city'],
                $request['address'],
                $request['comment'],
                $user);
            $this->orderService->create($dto);
            header("Location: /order");
            exit();
        } else {
            require_once '../Views/order_page.php';
        }
    }

    public function getOrderProduct()
    {
        if (!$this->authService->check()) {
            header('Location: ../login');
            exit();
        } else {

            $user = $this->authService->getCurrentUser();
            $userProducts = $this->userProductModel->getAllByUserId($user->getId());

            $total = 0;

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $product = $this->productModel->getByProduct($productId);
                $userProduct->setProduct($product);
                $total += $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            }
            require_once '../Views/order_page.php';
        }
    }
    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: ../login");
            exit();
        }
        $user = $this->authService->getCurrentUser();

        // достаем все заказы Order
        $userOrders = $this->orderModel->getAllByUserId($user->getId());

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
            // достаем продукты в заказах orderProduct по orderId
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $totalSum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getByProduct($orderProduct->getProductId());
                $orderProduct->setProduct($product);
                $totalSum += $orderProduct->getAmount() * $product->getPrice();
                $newOrderProducts[] = $orderProduct;
            }
            $userOrder->setOrderProducts($newOrderProducts);
            $userOrder->setTotal($totalSum);
            $newUserOrders[] = $userOrder;
        }
        require_once '../Views/order_product_page.php';
    }
}


