<?php
/**
 * DB is used for setting up a connection to a MySQL database.
 * DB is a singleton.
 *
 */
namespace ActivatorAdmin\Lib;

class DB
{
    private static $instance;

    private function __construct() {}

    /**
     * getInstance returns an instance of DB (Singleton Pattern).
     *
     * @return object DB
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * getConnection connects to a MySQL database and returns an instance of mysqli for further communication with the database.
     *
     * @param array $config is the db entry in the configuration array that is setup in config/config.php.
     *
     * @return object mysqli
     */
    public function getConnection($config)
    {
        $db = new \mysqli($config['host'], $config['user'], $config['pass'], $config['name']);

        $db->query("SET NAMES 'utf8'");

        return $db;
    }

}
