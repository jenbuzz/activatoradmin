<?php

namespace ActivatorAdmin\Lib;

class DB
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            $objConfigHelper = new ConfigHelper();
            $dbConfig = $objConfigHelper->get('db');

            switch ($dbConfig['activedb']) {
                case 'mongodb':
                    $config = $objConfigHelper->get('mongo');
                    static::$instance = Mongo::getInstance($config);
                    break;
                case 'mysql':
                default:
                    $config = $objConfigHelper->get('mysql');
                    static::$instance = MySQL::getInstance($config);
                    break;
            }
        }

        return static::$instance;
    }
}
