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

    /**
     * Execute a select query defined using the parameters.
     *
     * @param string $table is the name of table to run the select query on.
     * @param string $columns are the names of the columns to return. Not required. Default * (all columns).
     * @param string $where is the where clause for filtering the records. Not required.
     * @param int $limit is the number of records to return. Not required.
     */
    public function select($table, $columns='*', $where=false, $limit=false)
    {
        $sql = 'SELECT '.$columns.' FROM '.$table;
        if ($where) {
            $sql.= ' WHERE '.$where;
        }
        if ($limit) {
            $sql.= ' LIMIT '.$limit;
        }

        return $this->mysqli->query($sql);
    }

    /**
     * Execute an update query defined using the parameters.
     *
     * @param string table is the name of table to run the select query on.
     * @param array data is an array of fields to update - array key = column_name.
     * @param string where is the where clause for specifying what to records to update.
     */
    public function update($table, $data, $where=false)
    {
        $fields = array();

        foreach ($data AS $column_name => $value) {
            $fields[] = $column_name.'='.$value;
        }

        $sql = 'UPDATE '.$table.' SET '.implode(',', $fields);
        if ($where) {
            $sql.= ' WHERE '.$where;
        }

        $this->mysqli->query($sql);
    }

}
