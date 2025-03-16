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

    public function addProduct(AddProductRequest $request)
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $errors = $request->validate();
            if (empty($errors)) {
                $dto = new AddProductDTO($request->getProductId(), $user, $request->getAmount());
                $this->productService->addProduct($dto);
            }
            header('Location: catalog');
            exit;
        } else {
            header("Location: /catalog");
            exit();
        }
    }
    public function decreaseProduct(DecreaseProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: login');
            exit;
        }
        $user = $this->authService->getCurrentUser();
        $errors = $request->validate();
        if (empty($errors)) {
            $dto = new DecreaseProductDTO($request->getProductId(), $user, $request->getAmount());
            $this->productService->decreaseProduct($dto);
        }
        header("Location: /catalog");
        exit();
    }
}

