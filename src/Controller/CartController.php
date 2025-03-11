<?php

namespace Controller;

use Model\UserProduct;
use Model\Product;
use Service\AuthService;
use Service\CartService;


class CartController extends BaseController
{
    private UserProduct $cartModel;
    private Product $productModel;
    private CartService $productService;
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new UserProduct();
        $this->productModel = new Product();
        $this->productService = new CartService();
    }

    public function getCartPage()
    {
        require_once '../Views/cart_page.php';
    }

    public function getCart()
    {

        if (!$this->authService->check()) {
            header('Location: login');
            exit();
        } else {
            $user = $this->authService->getCurrentUser();
            $userProducts = $this->cartModel->getAllByUserId($user->getId());

            $totalOrderSum = 0;

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $product = $this->productModel->getByProduct($productId);
                $userProduct->setProduct($product);

                // стоимость текущего продукта
                $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();

                // сумма текущего продукта
                $userProduct->setTotal($totalSum);

                // Добавление стоимости текущего продукта к общей сумме
                $totalOrderSum += $totalSum;
            }
            $newUserProducts = $userProducts;
            require_once '../Views/cart_page.php';
        }
    }

    public function addProduct()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $productId = $_POST['product_id'];
            $amount = 1;
            $errors = $this->validateProduct($_POST);
            if (empty($errors)) {
                $this->productService->addProduct($productId, $user->getId(), $amount);
            }
            header('Location: catalog');
            exit;
        } else {
            header("Location: /catalog");
            exit();
        }
    }

    public function decreaseProduct()
    {
        if (!$this->authService->check()) {
            header('Location: login.php');
            exit;
        }
        $user = $this->authService->getCurrentUser();
        $productId = $_POST['product_id'];
        $this->productService->decreaseProduct($productId, $user->getId());
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

