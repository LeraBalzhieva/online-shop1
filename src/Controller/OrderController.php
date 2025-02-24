<?php
namespace Controller;
use Model\OrderProduct;
use Model\Order;
use Model\UserProduct;

class OrderController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
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

                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];
                $orderProduct->create($orderId, $productId, $amount);
            }

            $this->userProductModel->deleteByUserId($userId);

        } else {
            require_once '../Views/order_page.php';
        }
    }
    private function validateByOrder(array $data): array
    {
        $errors = [];
// объявление и валидация данных
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
}