<?php

use Controller\UserController;
use Controller\ProductController;
use Controller\OrderController;
use Controller\CartController;
use Core\App;
use Core\Autoloader;

require_once '../Core/Autoloader.php';

$path = dirname(__DIR__);
Autoloader::register($path);

$app = new App();

$app->get('/registration', UserController:: class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrateRequest::class);

$app->get('/login', UserController:: class, 'getLogin');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);

$app->get('/profile', UserController:: class, 'profile');
$app->post('/profile', UserController::class, 'getProfile');

$app->get('/editProfile', UserController:: class, 'getEditProfile');
$app->post('/editProfile', UserController::class, 'editProfile', \Request\EditProfileRequest::class);

$app->get('/logout', UserController:: class, 'logout');

$app->get('/catalog', ProductController:: class, 'catalog');
$app->post('/catalog', ProductController::class, 'getCatalog');

$app->get('/add-product', CartController:: class, 'getAddProduct');
$app->post('/add-product', CartController::class, 'addProduct', \Request\AddProductRequest::class);
$app->post('/decrease-product', CartController::class, 'decreaseProduct', Request\DecreaseProductRequest::class );


$app->get('/cart', CartController:: class, 'getCart');
$app->post('/cart', CartController::class, 'getCartPage');

$app->get('/order',OrderController:: class, 'getOrderProduct');
$app->post('/order',OrderController::class, 'order', Request\OrderRequest::class);

$app->get('/orderProduct', OrderController:: class, 'getAllOrders');


$app->post('/product',ProductController::class, 'getProductReviews');
$app->post('/review', ProductController::class, 'addReviews', \Request\AddReviewRequest::class );


$app->run();

