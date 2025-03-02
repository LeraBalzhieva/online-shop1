<?php

namespace Core;

class Autoloader
{
    public static function register(string $dir)
    {
        $autoload = function (string $className) use ($dir)
        {
            $header = str_replace('\\', '/', $className);
            $path = "$dir/$header.php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };
        spl_autoload_register($autoload);
    }

}