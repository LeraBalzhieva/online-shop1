<?php
namespace Controller;
use Model\OrderProduct;
use Model\Order;
use Model\Product;
use Model\UserProduct;

class OrderController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
    }
    public function getOrder()
    {
        require_once '../Views/order_page.php';
    }
    public function order()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: ../login");
            exit();
        }

        $errors = $this->validateByOrder($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['userId'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];

            $orderId = $this->orderModel->addOrder($name, $phone, $city, $address, $userId, $comment);

            $userProducts = $this->userProductModel->getAllByUserId($userId);


            $orderProduct = new OrderProduct();
            foreach ($userProducts as $userProduct) {

                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();
                $orderProduct->create($productId, $orderId, $amount);
            }

            $this->userProductModel->deleteByUserId($userId);
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: ../login');
            exit();
        } else {

            $userId = $_SESSION['userId'];
            $userProducts = $this->userProductModel->getAllByUserId($userId);

            $total =0;

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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: ../login");
            exit();
        }
        $userId = $_SESSION['userId'];

        // достаем все заказы Order
        $userOrders = $this->orderModel->getAllByUserId($userId);

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

    /*



         /*   $newOrderProducts = [];
            $sum = 0;*/

            }
                /*
                 * $orderProduct->setProduct($product);
                 * $orderProductTotal = $orderProduct->getPrice() * $orderProduct->getAmount();
                $orderProduct->setTotal($orderProductTotal);

                $newOrderProducts[] = $orderProduct;
                $sum += $orderProductTotal;
                
            }
            $userOrder->setTotal($sum);
            $userOrder->setProducts($newOrderProducts);
            $newUserOrders[] = $userOrder;*/


        require_once '../Views/order_product_page.php';
    }


}