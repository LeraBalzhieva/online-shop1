<?php

namespace Controller;
use Model\OrderProduct;
use Model\Order;
use Model\Product;
use Model\UserProduct;
use Service\AuthService;
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

    public function order()
    {
        $this->authService->startSession();

        if (!$this->authService->check()) {
            header("Location: ../login");
            exit();
        }

        $errors = $this->validateByOrder($_POST);

        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];

            $orderId = $this->orderModel->addOrder($name, $phone, $city, $address, $user->getId(), $comment);

            $this->orderService->order($user->getId(), $orderId);

            header("Location: /order");
            exit();

        } else {
            require_once '../Views/order_page.php';
        }

    }

    private function validateByOrder(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Имя не может содержать меньше 3 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }


        if (isset($data['phone'])) {
            $phone = $data['phone'];
            if (strlen($phone < 5)) {
                $errors['phone'] = "Введите корректный номер телефона";
            }
        } else {
            $errors['phone'] = "Поле должно быть заполнено";
        }

        if (isset($data['city'])) {
            $city = $data['city'];
            if (strlen($city) < 3) {
                $errors['city'] = "Введите правильный город";
            }
        } else {
            $errors['city'] = "Поле должно быть заполнено";
        }

        if (isset($data['address'])) {
            $address = $data['address'];
            if (strlen($address) < 3) {
                $errors['address'] = "Введите правильный адрес";
            }
        } else {
            $errors['address'] = "Поле должно быть заполнено";
        }
        return $errors;
    }

    public function getOrderProduct()
    {
        $this->authService->startSession();

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
        $this->authService->startSession();

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


