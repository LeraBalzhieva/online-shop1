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
$app->post('/registration', UserController::class, 'registrate');

$app->get('/login', UserController:: class, 'getLogin');
$app->post('/login', UserController::class, 'login');

$app->get('/profile', UserController:: class, 'profile');
$app->post('/profile', UserController::class, 'getProfile');

$app->get('/editProfile', UserController:: class, 'getEditProfile');
$app->post('/editProfile', UserController::class, 'editProfile');

$app->get('/logout', UserController:: class, 'logout');

$app->get('/catalog', ProductController:: class, 'catalog');
$app->post('/catalog', ProductController::class, 'getCatalog');

$app->get('/add-product', ProductController:: class, 'getAddProduct');
$app->post('/add-product', ProductController::class, 'addProduct');
$app->post('/decrease-product', ProductController::class, 'decreaseProduct');


$app->get('/cart', CartController:: class, 'getCart');
$app->post('/cart', CartController::class, 'getCartPage');

$app->get('/order',OrderController:: class, 'getOrderProduct');
$app->post('/order',OrderController::class, 'order');

$app->get('/orderProduct', OrderController:: class, 'getAllOrders');



$app->run();

