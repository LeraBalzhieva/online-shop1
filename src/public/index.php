<?php

$autoload = function (string $className) {
    $header = str_replace('\\', '/', $className);
    $path = "./../$header.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    } return false;
};

spl_autoload_register($autoload);

require_once "../Core/App.php";

$app = new Core\App();
$app->run();

/*$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// регистрация
if ($requestUri === '/registration') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    if ($requestMethod === 'GET') {
        $user->getRegistrate();
    } elseif ($requestMethod === 'POST') {
        $user->registrate();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // логин
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    if ($requestMethod === 'GET') {
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
        $user->login();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

// каталог
} elseif ($requestUri === '/catalog') {
    require_once '../Controller/ProductController.php';
    $product = new ProductController();
    if ($requestMethod === 'CET') {
        $product->getCatalog();
    } elseif ($requestMethod === 'GET') {
        $product->Catalog();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // выдача профиля
} elseif ($requestUri === '/profile') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    if ($requestMethod === 'POST') {
        $user->getProfile();
    } elseif ($requestMethod === 'GET') {
        $user->profile();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // изменение профиля
} elseif ($requestUri === '/editProfile') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    if ($requestMethod === 'GET') {
        $user->getEditProfile();
    } elseif ($requestMethod === 'POST') {
        $user->editProfile();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }


} elseif ($requestUri === '/add-product') {
    require_once '../Controller/ProductController.php';
    $product = new ProductController();
    if ($requestMethod === 'GET') {
        $product->addProductForm();
    } elseif ($requestMethod === 'POST') {
        $product->addProduct();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

} elseif ($requestUri === '/cart') {
    require_once '../Controller/CartController.php';
    $cart = new CartController();
    if ($requestMethod === 'GET') {
        $cart->getCart();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }


} else {
    http_response_code(404);
    require_once './404.php';
}*/