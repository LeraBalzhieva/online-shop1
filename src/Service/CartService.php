<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\UserProduct;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;

class CartService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }
    public function addProduct(AddProductDTO $data)
    {
        $amount =1;
        $product = $this->userProductModel->getByUserProducts($data->getUser()->getId(), $data->getProductId());
        if (!$product) {
            $this->userProductModel->addUserProduct($data->getUser()->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $amount + $product->getAmount();
            $this->userProductModel->updateUserProduct($data->getUser()->getId(), $data->getProductId(), $newAmount);
        }
    }

    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $products = $this->userProductModel->getByUserProducts($data->getUser()->getId(), $data->getProductId());

        if ($products !== null) {
            $amount = $products->getAmount();
            if ($amount > 1) {
                $newAmount = $amount - 1;
                $this->userProductModel->updateUserProduct($data->getUser()->getId(), $data->getProductId(), $newAmount);
            } else {
                $this->userProductModel->deleteUserProduct($data->getUser()->getId(), $data->getProductId());
            }
        }
    }
}