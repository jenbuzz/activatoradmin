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
     * @param string $whereColoumn is the column name for the where clause for filtering the records. Not required.
	 * @param string $whereValue is the value for the where clause for filtering the records. Not required.
     * @param int $limit is the number of records to return. Not required.
     */
    public function select($table, $columns='*', $whereColumn=false, $whereValue=false, $limit=false)
    {
        $sql = 'SELECT '.$columns.' FROM '.$table;
        if ($whereColumn && $whereValue) {
            $sql.= ' WHERE '.$whereColumn.'='.$this->mysqli->real_escape_string($whereValue);
        }
        if ($limit) {
            $sql.= ' LIMIT '.$limit;
        }

        return $this->mysqli->query($sql);
    }

    /**
     * Execute an insert query defined using the parameters.
     *
     * TODO: so far just a dummy function.
     */
    public function insert($table, $data)
    {
        $fields = array();
        $values = array();

        foreach ($data AS $column_name => $value) {
            $fields[] = $column_name;
            $values[] = '"'.$this->mysqli->real_escape_string($value).'"';
        }

        $sql = 'INSERT INTO '.$table.' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')';
        $this->mysqli->query($sql);
    }

    /**
     * Execute an update query defined using the parameters.
     *
     * @param string table is the name of table to run the select query on.
     * @param array data is an array of fields to update - array key = column_name.
     * @param string whereColumn is the column name for the where clause for specifying what to records to update.
	 * @param string whereValue is the value for the where clause for specifying what to records to update.
     */
    public function update($table, $data, $whereColumn=false, $whereValue=false)
    {
        $fields = array();

        foreach ($data AS $column_name => $value) {
            $fields[] = $column_name.'='.$this->mysqli->real_escape_string($value);
        }

        $sql = 'UPDATE '.$table.' SET '.implode(',', $fields);
        if ($whereColumn && $whereValue) {
            $sql.= ' WHERE '.$whereColumn.'='.$this->mysqli->real_escape_string($whereValue);
        }

        $this->mysqli->query($sql);
    }

    /**
     * Execute a delete query defined using the parameters.
     *
     * @param string $table is the name of table to run the delete query on.
     * @param string $whereColumn is the column name for the where clause for specifying what to records to delete.
	 * @param string $whereValue is the value for the where clause for specifying what to records to delete.
     */
    public function delete($table, $whereColumn, $whereValue)
    {
        $sql = 'DELETE FROM '.$table.' WHERE '.$whereColumn.'='.$whereValue;

        $this->mysqli->query($sql);
    }

}
