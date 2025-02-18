<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'Catalog',

            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',

            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'getProfile',

            ],
        ],
        '/editProfile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditProfile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart',
            ],
            'POST' => [
                'class' => 'CartController',
                'method' => 'getCartPage',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout',
            ],
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

                require_once "../Controller/$class.php";

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