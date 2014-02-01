<?php
namespace ActivatorAdmin\Lib;

class DB
{
    private static $instance;

    private function __construct() {}

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Setup mysql connection
     */
    public function getConnection($config)
    {
        $db = new \mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

        return $db;
    }

}
