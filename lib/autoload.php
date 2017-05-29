<?php

/**
 * ActivatorAdmin, Monolog, Psr/Log, Psr/Http-Message, Slim, Pimple, Interop/Container, FastRoute, Twig.
 */
spl_autoload_register(function($class) {
    if (substr($class, 0, 7)==='Monolog') {
        require __DIR__ . '/' . str_replace("\\", '/', $class) . '.php';
    } elseif (substr($class, 0, 7)==='Psr\\Log') {
        require __DIR__ . '/Psr/Log/' . str_replace("\\", "/", str_replace("Psr\\Log\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 8)==='Psr\\Http') {
        require __DIR__ . '/Psr/Http-Message/' . str_replace("\\", "/", str_replace("Psr\\Http\\Message\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 13)==='Psr\\Container') {
        require __DIR__ . '/Psr/Container/' . str_replace("\\", "/", str_replace("Psr\\Container\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 4)==='Slim') {
        require __DIR__ . '/Slim/' . str_replace("\\", "/", str_replace("Slim\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 6)==='Pimple') {
        require __DIR__ . '/Pimple/' . str_replace("Pimple\\", '', $class) . '.php';
    } elseif (substr($class, 0, 7)==='Interop') {
        require __DIR__ . '/Interop/Container/' . str_replace("\\", "/", str_replace("Interop\\Container\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 9)==='FastRoute') {
        require __DIR__ . '/FastRoute/' . str_replace("\\", "/", str_replace("FastRoute\\", '', $class)) . '.php';
    } elseif (substr($class, 0, 4)==='Twig') {
        require __DIR__ . '/Twig/' . str_replace("_", "/", str_replace("Twig_", '', $class)) . '.php';
    } elseif (substr($class, 0, 18)==='ActivatorAdmin\\Lib') {
        $class = str_replace('ActivatorAdmin\\Lib\\', '', $class);

        if (substr($class, 0, 1)==='i') {
            require __DIR__ . '/' . substr($class, 1) . '.interface.php';
        } else {
            require __DIR__ . '/' . $class . '.class.php';
        }
    }
});

require __DIR__ . '/FastRoute/functions.php';

?>
