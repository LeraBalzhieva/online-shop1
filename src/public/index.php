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

