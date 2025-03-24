<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\AddReviewRequest;

class ProductController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
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
            $products = Product::getByCatalog();
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
        $products = Product::getByProduct($productId);
        $reviews = Review::getReviews($productId);
        $averageRating = Review::getAverageRating($productId);
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

            $review =Review::addReview(
                $request->getProductId(),
                $user->getId(),
                $request->getRating(),
                $request->getComment());
        }
        $this->getProductReviews();
    }
}