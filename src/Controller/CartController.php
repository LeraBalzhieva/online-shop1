<?php

namespace Controller;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\UserProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class CartController extends BaseController
{
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
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
            $userProducts = $this->cartService->getUserProducts();
            require_once '../Views/cart_page.php';
        }
    }
    public function getUserProducts()
    {
        if (!$this->authService->check()) {
            header('Location: login');
            exit();

        } else {
            $userProducts = $this->cartService->getUserProducts();
        }
        require_once '../Views/order_page.php';
    }
    public function addProduct(AddProductRequest $request)
    {
        if ($this->authService->check()) {
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new AddProductDTO($request->getProductId());
                $this->cartService->addProduct($dto);
            }
            header("Location: /cart");
            exit;
        } else {
            header("Location: /login");
            exit();
        }
    }
    public function decreaseProduct(DecreaseProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $errors = $request->validate();
        if (empty($errors)) {
            $dto = new DecreaseProductDTO($request->getProductId());
            $this->cartService->decreaseProduct($dto);
        }
        header("Location: /cart");
        exit();
    }
}

