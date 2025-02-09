<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// регистрация
if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registration_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration_form.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // логин
} elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './login_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

// каталог
} elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'POST') {
        require_once './catalog_page.php';
    } elseif ($requestMethod === 'GET') {
        require_once './catalog.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // выдача профиля
} elseif ($requestUri === '/profile') {
    if ($requestMethod === 'POST') {
        require_once './profile_page.php';
    } elseif ($requestMethod === 'GET') {
        require_once './profile.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }

    // изменение профиля
} elseif ($requestUri === '/profile_change') {
    if ($requestMethod === 'GET') {
        require_once './profile_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_profile.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
} elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        require_once './add_product_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_add_product.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
} elseif ($requestUri === '/cart') {
    if ($requestMethod === 'POST') {
        require_once './cart_page.php';
    } elseif ($requestMethod === 'GET') {
        require_once './cart.php';
    } else {
        echo "HTTP метод $requestMethod не работает";
    }


} else {
    http_response_code(404);
    require_once './404.php';
}