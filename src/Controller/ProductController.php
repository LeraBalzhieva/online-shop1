<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Model\Review;
use Service\CartService;

class ProductController extends BaseController
{
    private Review $reviewModel;
    private Product $productModel;


    public function __construct()
    {
        parent::__construct();
        $this->reviewModel = new Review();
        $this->productModel = new Product();

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
        if ($this->authService->check()) {
            $products = $this->productModel->getByCatalog();
            require_once '../Views/catalog_page.php';
        } else {
            header("Location: login");
            exit();
        }
    }

    public function getProductReviews()
    {
        if (!$this->authService->check()) {
            header('Location: login');
            exit;
        }
        $productId = (int)$_POST['product_id'];
        $products = $this->productModel->getByProduct($productId);
        $reviews = $this->reviewModel->getReviews($productId);

        $averageRating = (float)$this->reviewModel->getAverageRating($productId);


        require_once '../Views/reviews_page.php';
    }

    public function addReviews()
    {
        if (!$this->authService->check()) {
            header("ocation: login");
            exit;
        }
        $errors = $this->reviewValidate($_POST);
        if (empty($errors)) {

            $user = $this->authService->getCurrentUser();
            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $review = $this->reviewModel->addReview($productId, $user->getId(), $rating, $comment);
            /* header("Location: /product");
             exit();*/
        }
        $this->getProductReviews();
    }

    private function reviewValidate(array $data): array
    {
        $errors = [];
        if (isset($data['comment'])) {
            $reviewComment = $data['comment'];
            if (strlen($reviewComment) < 2 || strlen($reviewComment) > 255) {
                $errors['comment'] = 'Длина строки должна быть больше 2 и меньше 255';
            }
        }
        return $errors;
    }
}