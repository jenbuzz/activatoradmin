<?php

namespace ActivatorAdmin\Lib;

/**
 * MySQL is used for setting up a connection to a MySQL database.
 * MySQL is a singleton.
 *
 */
class MySQL implements iDatabase
{
    private static $instance;
    private $mysqli;
    private $table;

    /**
     * Connect to a MySQL database with the credentials from the $config['mysql'] array.
     *
     * @param array $config is the mysql entry in the configuration array that is setup in class ConfigHelper.
     */
    private function __construct(array $config)
    {
        $this->mysqli = new \mysqli($config['host'], $config['user'], $config['pass'], $config['name']);

        $this->mysqli->query("SET NAMES 'utf8'");

        $this->setTable($config['table']);
    }

    /**
     * getInstance returns an instance of MySQL (Singleton Pattern).
     *
     * @param array $config is the db entry in the configuration array that is setup in class ConfigHelper.
     *
     * @return object MySQL
     */
    public static function getInstance(array $config)
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
        return $this->mysqli;
    }

    /**
     * Set the current table used for queries.
     *
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * Get the current table used for queries.
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Execute a direct query.
     *
     * @param string $sql is the sql query string.
     */
    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }

    /**
     * Execute a select query defined using the parameters.
     *
     * @param string $columns are the names of the columns to return. Not required. Default * (all columns).
     * @param string $whereColoumn is the column name for the where clause for filtering the records. Not required.
     * @param string $whereValue is the value for the where clause for filtering the records. Not required.
     * @param string $orderBy is the column name and direction for sorting records.
     * @param int $limit is the number of records to return. Not required.
     */
    public function select($columns='*', $whereColumn=false, $whereValue=false, $orderBy=false, $limit=false)
    {
        $sql = 'SELECT '.$columns.' FROM '.$this->getTable();
        if ($whereColumn && $whereValue) {
            $sql.= ' WHERE '.$whereColumn.'='.$this->mysqli->real_escape_string($whereValue);
        }
        if ($orderBy) {
            $sql.= ' ORDER BY '.$orderBy;
        }
        if ($limit) {
            $sql.= ' LIMIT '.$limit;
        }

        $result = $this->mysqli->query($sql);
        $arrData = array();
        if ($result && $result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                $arrData[] = $row;
            }
        }
        $result->free();

        if (count($arrData)===1) {
            $arrData = $arrData[0];
        }

        return $arrData;
    }

    /**
     * Execute an insert query defined using the parameters.
     *
     * @param array $data is array of data to insert. Array key is column name.
     */
    public function insert($data)
    {
        $fields = array();
        $values = array();

        foreach ($data AS $column_name => $value) {
            $fields[] = $column_name;
            $values[] = '"'.$this->mysqli->real_escape_string($value).'"';
        }

        $sql = 'INSERT INTO '.$this->getTable().' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')';
        $this->mysqli->query($sql);

        return $this->mysqli->insert_id;
    }

    /**
     * Execute an update query defined using the parameters.
     *
     * @param array $data is an array of fields to update - array key = column_name.
     * @param string $whereColumn is the column name for the where clause for specifying what to records to update.
     * @param string $whereValue is the value for the where clause for specifying what to records to update.
     */
    public function update($data, $whereColumn=false, $whereValue=false)
    {
        $fields = array();

        foreach ($data AS $column_name => $value) {
            $fields[] = $column_name.'="'.$this->mysqli->real_escape_string($value).'"';
        }

        $sql = 'UPDATE '.$this->getTable().' SET '.implode(',', $fields);
        if ($whereColumn && $whereValue) {
            $sql.= ' WHERE '.$whereColumn.'='.$this->mysqli->real_escape_string($whereValue);
        }

        $this->mysqli->query($sql);
    }

    /**
     * Execute a delete query defined using the parameters.
     *
     * @param string $whereColumn is the column name for the where clause for specifying what to records to delete.
     * @param string $whereValue is the value for the where clause for specifying what to records to delete.
     */
    public function delete($whereColumn, $whereValue)
    {
        $sql = 'DELETE FROM '.$this->getTable().' WHERE '.$whereColumn.'='.$this->mysqli->real_escape_string($whereValue);

        $this->mysqli->query($sql);
    }

    /**
     * Search in a table for a searchterm in specified column.
     *
     * @param string $searchColumn is the name of the column in which the searchterm should appear.
     * @param string $searchTerm is the term to search for in searchColumn.
     */
    public function search($searchColumn, $searchTerm)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE '.$searchColumn.' LIKE "%'.$searchTerm.'%"';

        $result = $this->mysqli->query($sql);
        $arrData = array();
        if ($result && $result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                $arrData[] = $row;
            }
        }
        $result->free();

        return $arrData;
    }

}
