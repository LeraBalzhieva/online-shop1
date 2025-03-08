<?php
namespace Controller;

use Model\UserProduct;
use Model\Product;

class CartController
{
    private UserProduct $cartModel;
    private Product $productModel;
    public function __construct()
    {
        $this->cartModel = new UserProduct();
        $this->productModel = new Product();
    }
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

            $userId = $_SESSION['userId'];
            $userProducts = $this->cartModel->getAllByUserId($userId);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $product = $this->productModel->getByProduct($productId);
                $userProduct->setProduct($product);
                $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            }
            require_once '../Views/cart_page.php';
        }
    }

}

