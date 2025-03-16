<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\AddProductRequest;
use Request\AddReviewRequest;

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
    public function addReviews(AddReviewRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: login");
            exit;
        }
        $errors = $request->validate();
        if (empty($errors)) {

            $user = $this->authService->getCurrentUser();

            $review = $this->reviewModel->addReview(
                $request->getProductId(),
                $user->getId(),
                $request->getRating(),
                $request->getComment());
        }
        $this->getProductReviews();
    }

}