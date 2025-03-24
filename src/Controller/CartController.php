<?php

namespace Controller;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;

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

    public function addProduct(AddProductRequest $request)
    {
        if ($this->authService->check()) {
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new AddProductDTO($request->getProductId());
                $this->cartService->addProduct($dto);
            }
        }
    }

    public function decreaseProduct(DecreaseProductRequest $request)
    {
        if ($this->authService->check()) {
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new DecreaseProductDTO($request->getProductId());
                $this->cartService->decreaseProduct($dto);
            }
        }
    }
}

