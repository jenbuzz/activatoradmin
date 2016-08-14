<?php

namespace ActivatorAdmin\Lib;

class DB
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance($activeDb = false)
    {
        if (static::$instance === null) {
            $objConfigHelper = new ConfigHelper();

            if (!$activeDb) {
                $dbConfig = $objConfigHelper->get('db');
                $activeDb = $dbConfig['activedb'];
            }

            switch ($activeDb) {
                case 'mongodb':
                    $config = $objConfigHelper->get('mongodb');
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

    public static function destroy() {
        self::$instance = null;
    }
}
