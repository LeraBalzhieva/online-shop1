<?php

namespace Controller;

use Model\UserProduct;
use Model\Product;


class CartController extends BaseController
{
    private UserProduct $cartModel;
    private Product $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new UserProduct();
        $this->productModel = new Product();
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

