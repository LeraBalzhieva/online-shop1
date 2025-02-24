<?php

namespace Core;

use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;
use Controller\UserController;

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => UserController:: class,
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => UserController:: class,
                'method' => 'registrate',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => UserController:: class,
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => UserController:: class,
                'method' => 'login',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => ProductController:: class,
                'method' => 'Catalog',

            ],
            'POST' => [
                'class' => ProductController:: class,
                'method' => 'getCatalog',

            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => UserController:: class,
                'method' => 'profile',
            ],
            'POST' => [
                'class' => UserController:: class,
                'method' => 'getProfile',

            ],
        ],
        '/editProfile' => [
            'GET' => [
                'class' => UserController:: class,
                'method' => 'getEditProfile',
            ],
            'POST' => [
                'class' => UserController:: class,
                'method' => 'editProfile',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => ProductController:: class,
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => ProductController:: class,
                'method' => 'addProduct',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController:: class,
                'method' => 'getCart',
            ],
            'POST' => [
                'class' => CartController:: class,
                'method' => 'getCartPage',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController:: class,
                'method' => 'logout',
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController:: class,
                'method' => 'getOrder',
            ],
            'POST' => [
                'class' => OrderController:: class,
                'method' => 'order',
            ]
        ],


    ];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {

                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

           //     require_once "../Controller/$class.php";

                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддеривается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }
    }

}