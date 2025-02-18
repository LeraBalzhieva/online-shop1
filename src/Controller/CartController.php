<?php

class CartController
{
    public function getCartPage()
    {
        require_once '../Views/cart_page.php';
    }
    public function getCart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: ../login');
            exit();
        } else {
            require_once '../Model/UserProduct.php';
            $userId = $_SESSION['userId'];
            $cartModel = new UserProduct();
            $userProducts = $cartModel->getByUserProduct($userId);

            $products = [];

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];

                require_once '../Model/Product.php';
                $productModel = new Product();
                $product = $productModel->getByProduct($productId);

                $product['amount'] = $userProduct['amount'];
                $products[] = $product;
            }

            require_once '../Views/cart_page.php';
        }
    }

}


?>


