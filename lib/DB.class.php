<?php

namespace ActivatorAdmin\Lib;

/**
 * DB class is used for returning an instance of the active database (mongodb/mysql).
 * DB is a singleton.
 */
class DB
{
    private static $instance;

    /**
     * Private contructor for singleton purpose.
     */
    private function __construct()
    {
    }

    /**
     * Returns a singleton instance of MySQL or Mongo.
     * The active database set in config.ini will be used as default.
     *
     * @param string $activeDb is to force the active database setting
     */
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

    /**
     * Detroy the current singleton instance (if the active database needs to be changed dynamically).
     */
    public static function destroy()
    {
        self::$instance = null;
    }
}
