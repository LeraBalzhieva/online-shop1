<?php
namespace Controller;


class OrderController
{
    public function getOrder()
    {
        require_once '../Views/order_page.php';
    }

    public function order()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {

            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->verification($_SESSION['userId']);

            require_once '../Views/order_page.php';
        } else {
            header("Location: ../login");
        }

        $errors = $this->validateByOrder($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['userId'];
            $name = $_POST['name'];
            $email = $_POST['mail'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];

            //добавление данных и
            require_once '../Model/Order.php';
            $orderModel = new Order();
            $order = $orderModel->addOrder($name, $email, $phone, $city, $address);

            $cartModel = new UserProduct();
            $cartProducts = $cartModel->getByUserProduct($userId);
            header("Location: ../order");
        }
        require_once '../Views/order_page.php';
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

        if (isset($data['mail'])) {
            $email = $data['mail'];
            if (strlen($email) < 3) {
                $errors['email'] = "Email не может содержать меньше 3 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            }
        } else {
            $errors['email'] = "Email должен быть заполнен";
        }

        if (isset($data['phone'])) {
            $phone = $data['phone'];
            if (strlen($phone) < 12) {
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