<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }

    public function getCatalog()
    {
        require_once '../Views/catalog_page.php';
    }

    public function getAddProduct()
    {
        require_once '../Views/add_product_form.php';
    }

    public function catalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {

            $products = $this->productModel->getByCatalog($_SESSION['userId']);
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

        $errors = $this->validateProduct($_POST);
        if (empty($errors)) {

            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $product = $this->userProductModel->getByUserProducts($userId, $productId);

            if ($product === false) {
                $this->userProductModel->addUserProduct($userId, $productId, $amount);

            } else {
                $amount = $amount + $product['amount'];
                $this->userProductModel->updateUserProduct($userId, $productId, $amount);
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

            $product = $this->productModel->getByProduct($productId);

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