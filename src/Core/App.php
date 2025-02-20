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
                'class' => 'Controller\UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'registrate',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'login',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'Controller\ProductController',
                'method' => 'Catalog',

            ],
            'POST' => [
                'class' => 'Controller\ProductController',
                'method' => 'getCatalog',

            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'getProfile',

            ],
        ],
        '/editProfile' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getEditProfile',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'editProfile',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'Controller\ProductController',
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => 'Controller\ProductController',
                'method' => 'addProduct',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'Controller\CartController',
                'method' => 'getCart',
            ],
            'POST' => [
                'class' => 'Controller\CartController',
                'method' => 'getCartPage',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'logout',
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => 'Controller\OrderController',
                'method' => 'getOrder',
            ],
            'POST' => [
                'class' => 'Controller\OrderController',
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