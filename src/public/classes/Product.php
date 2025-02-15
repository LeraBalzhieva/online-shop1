<?php

class Product
{
    public function getCatalog()
    {
        require_once './catalog/catalog_page.php';
    }
    public function addProductForm()
    {
        require_once './addProduct/add_product_form.php';
    }

    public function Catalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {
            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            //если пользователь найден, выдаем каталог
            $stmt = $pdo->query('SELECT * FROM products');
            $products = $stmt->fetchAll();
            require_once './catalog/catalog_page.php';
        } else {
            header("Location: /login/login");
            exit();
        }
    }
    public function addProduct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: ../login.php');
            exit;
        }
        $errors = $this->validateProduct($_POST);
        if (empty($errors)) {
            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');

            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :productId");
            $stmt->execute([':user_id' => $userId, ':productId' => $productId]);
            $data = $stmt->fetch();
            if ($data === false) {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
                $stmt->execute([':userId' => $userId, ':productId' => $productId, ':amount' => $amount]);
            } else {
                $amount = $amount + $data['amount'];

                $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
                $stmt->execute([':amount' => $amount, ':userId' => $userId, ':productId' => $productId]);
            }
        }
        header("Location: /catalog");
        exit();
    }
    private function validateProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int)$data['product_id'];

            $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :productId");
            $stmt->execute([':productId' => $productId]);
            $data = $stmt->fetch();

            if ($data === false) {
                $errors['product_id'] = "Продукт не найден";
            }
            if ($productId < 1) {
                $errors['product_id'] = "Id не может быть отрицательным";
            }
        } else {
            $errors['product_id'] = "Строка должна быть заполнена";
        }

//        if (isset($data['amount'])) {
//            $amount = (int)$data['amount'];
//            if (($amount < 1) || ($amount) > 100) {
//                $errors['amount'] = "Количество не может быть отрицательным и больше 100";
//            }
//        } else {
//            $errors['amount'] = "Строка должна быть заполнена";
//        }
        return $errors;

    }



}