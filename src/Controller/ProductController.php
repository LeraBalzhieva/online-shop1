<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        parent::__construct();
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
        $this->authService->startSession();

        if ($this->authService->check()) {
            $products = $this->productModel->getByCatalog();


            require_once '../Views/catalog_page.php';
        } else {
            header("Location: login");
            exit();
        }
    }

    public function addProduct()
    {
        $this->authService->startSession();

        if (!$this->authService->check()) {
            header('Location: login.php');
            exit;
        }
        $errors = $this->validateProduct($_POST);
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $productId = $_POST['product_id'];
            $amount = 1;
            $product = $this->userProductModel->getByUserProducts($user->getId(), $productId);
            if (!$product) {
                $this->userProductModel->addUserProduct($user->getId(), $productId, $amount);
            } else {
                $newAmount = $amount + $product->getAmount();
                $this->userProductModel->updateUserProduct($user->getId(), $productId, $newAmount);
            }
        }
        header("Location: /catalog");
        exit();
    }

    public function decreaseProduct()
    {
        $this->authService->startSession();

        if (!$this->authService->check()) {
            header('Location: login.php');
            exit;
        }
        $user = $this->authService->getCurrentUser();
        $productId = $_POST['product_id'];
        $products = $this->userProductModel->getByUserProducts($user->getId(), $productId);

        if ($products !== null) {
            $amount = $products->getAmount();
            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateUserProduct($user->getId(), $productId, $newAmount);
            } else {
                $this->userProductModel->deleteUserProduct($user->getId(), $productId);
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

        return $errors;
    }
}