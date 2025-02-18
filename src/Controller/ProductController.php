<?php
class ProductController
{
    public function getCatalog()
    {
        require_once '../Views/catalog_page.php';
    }

    public function getAddProduct()
    {
        require_once '../Views/add_product_form.php';
    }

    public function Catalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {

            require_once '../Model/Product.php';
            $productModel = new Product();
            $products = $productModel->getByCatalog($_SESSION['userId']);

            require_once '../Views/catalog_page.php';
        } else {
            header("Location: ../login");
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
        require_once '../Model/Product.php';

        $errors = $this->validateProduct($_POST);
        if (empty($errors)) {

            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];


            $productModel = new Product();
            $product = $productModel->getByUserProducts($userId, $productId);

            if ($product === false) {
                $productModel->addUserProduct($userId, $productId, $amount);

            } else {
                $amount = $amount + $product['amount'];
                $productModel->updateUserProduct($userId, $productId, $amount);
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

            require_once '../Model/Product.php';
            $productModel = new Product();
            $product = $productModel->getByProduct($productId);

            if ($product === false) {
                $errors['product_id'] = "Продукт не найден";
            }
            if ($productId < 1) {
                $errors['product_id'] = "Id не может быть отрицательным";
            }
        } else {
            $errors['product_id'] = "Строка должна быть заполнена";
        }

        if (isset($data['amount'])) {
            $amount = (int)$data['amount'];
            if (($amount < 1) || ($amount) > 100) {
                $errors['amount'] = "Количество не может быть отрицательным и больше 100";
            }
        } else {
            $errors['amount'] = "Строка должна быть заполнена";
        }
        return $errors;
    }
}