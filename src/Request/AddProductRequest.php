<?php

namespace Request;

use Model\Product;

class AddProductRequest
{
    private Product $productModel;

    public function __construct(private array $data)
    {
        $this->productModel = new Product();
    }
    public function getProductId(): int
    {
        return $this->data['product_id'];
    }
    public function getAmount(): int
    {
        return $this->data['amount'];
    }
    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = (int)$this->data['product_id'];

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