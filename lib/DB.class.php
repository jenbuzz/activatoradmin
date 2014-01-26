<?php
namespace ActivatorAdmin\Lib;

class DB
{

    private function __construct() {}

    public static function getInstance()
    {
        static $instance;

        if (!isset($instance)) {
            $instance = new DB();
        }

        return $instance;
    }

    /**
     * Setup mysql connection
     */
    function getConnection($config)
    {
        $db = new \mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);
        return $db;
    }

}

