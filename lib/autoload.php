<?php

/**
 * ActivatorAdmin, Monolog & Psr/Log.
 */
spl_autoload_register(function($class) {
    if (substr($class, 0, 7)=='Monolog') {
        require __DIR__ . '/' . str_replace("\\", '/', $class) . '.php';
    } elseif (substr($class, 0, 3)=='Psr') {
        require __DIR__ . '/Psr/Log/' . str_replace("Psr\\Log\\", '', $class) . '.php';
    } elseif (substr($class, 0, 4)!=='Slim') {
        $class = str_replace('ActivatorAdmin\\Lib\\', '', $class);

        if (substr($class, 0, 1)==='i') {
            require __DIR__ . '/' . substr($class, 1) . '.interface.php';
        } else {
            require __DIR__ . '/' . $class . '.class.php';
        }
    }
});

/**
 * Slim Framework.
 */
require_once __DIR__ . '/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

?>
