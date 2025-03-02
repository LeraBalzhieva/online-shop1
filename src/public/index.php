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

$app->addRoute('/registration', 'GET', UserController:: class, 'getRegistrate');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');

$app->addRoute('/login', 'GET', UserController:: class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');

$app->addRoute('/profile', 'GET', UserController:: class, 'profile');
$app->addRoute('/profile', 'POST', UserController::class, 'getProfile');

$app->addRoute('/editProfile', 'GET', UserController:: class, 'getEditProfile');
$app->addRoute('/editProfile', 'POST', UserController::class, 'editProfile');

$app->addRoute('/logout', 'GET', UserController:: class, 'logout');

$app->addRoute('/catalog', 'GET', ProductController:: class, 'catalog');
$app->addRoute('/catalog', 'POST', ProductController::class, 'getCatalog');

$app->addRoute('/add-product', 'GET', ProductController:: class, 'getAddProduct');
$app->addRoute('/add-product', 'POST', ProductController::class, 'addProduct');

$app->addRoute('/cart', 'GET', CartController:: class, 'getCart');
$app->addRoute('/cart', 'POST', CartController::class, 'getCartPage');

$app->addRoute('/order', 'GET', OrderController:: class, 'getOrderProduct');
$app->addRoute('/order', 'POST', OrderController::class, 'order');

$app->addRoute('/orderProduct', 'GET', OrderController:: class, 'getAllOrders');

$app->run();

