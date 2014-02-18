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
    private $mysqli;

    /**
     * Connect to a MySQL database with the credentials from the $config['db'] array.
     *
     * @param array $config is the db entry in the configuration array that is setup in config/config.php.
     */
    private function __construct($config)
    {
        $this->mysqli = new \mysqli($config['host'], $config['user'], $config['pass'], $config['name']);
    }

    /**
     * getInstance returns an instance of DB (Singleton Pattern).
     *
     * @param array $config is the db entry in the configuration array that is setup in config/config.php.
     *
     * @return object DB
     */
    public static function getInstance($config)
    {
        if (static::$instance === null) {
            static::$instance = new static($config);
        }

        return static::$instance;
    }

    /**
     * getConnection returns a reference to the mysqli object created in the contructer.
     *
     * @return object mysqli
     */
    public function getConnection()
    {
        $this->mysqli->query("SET NAMES 'utf8'");

        return $this->mysqli;
    }

}
