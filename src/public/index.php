<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// регистрация
if ($requestUri === '/registration') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getRegistrate();
    } elseif ($requestMethod === 'POST') {
        $user->registrate();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // логин
} elseif ($requestUri === '/login') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
        $user->login();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

// каталог
} elseif ($requestUri === '/catalog') {
    require_once './classes/Product.php';
    $product = new Product();
    if ($requestMethod === 'CET') {
        $product->getCatalog();
    } elseif ($requestMethod === 'GET') {
        $product->Catalog();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // выдача профиля
} elseif ($requestUri === '/profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->profile();
    } elseif ($requestMethod === 'POST') {
        require_once './profile/profile_page.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // изменение профиля
} elseif ($requestUri === '/editProfile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getEditProfile();
    } elseif ($requestMethod === 'POST') {
        $user->editProfile();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }


} elseif ($requestUri === '/add-product') {
    require_once './classes/Product.php';
    $product = new Product();
    if ($requestMethod === 'GET') {
        $product->addProductForm();
    } elseif ($requestMethod === 'POST') {
        $product->addProduct();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

} elseif ($requestUri === '/cart') {
    if ($requestMethod === 'GET') {
        require_once './cart/cart.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }


} else {
    http_response_code(404);
    require_once './404.php';
}