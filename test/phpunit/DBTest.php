<?php
/**
 * Test the database class.
 * Database: MySQL.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once(__DIR__ . '/../../lib/DB.class.php');

class DBTest extends \PHPUnit_Framework_TestCase
{
    protected $db;

    /**
     * Connects to a MySQL database and gets an instance of DB.
     * MySQL connection credentials are pulled from /config/config.php.
     */
    protected function setUp()
    {
        require(__DIR__ . '/../../config/config.php');
        $this->db = \ActivatorAdmin\Lib\DB::getInstance($config['db']);
    }

    /**
     * Test the if the singleton function getInstance() returns DB.
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf('\ActivatorAdmin\Lib\DB', $this->db);
    }

    /**
     * Test getting a database connection.
     */
    public function testGetConnection()
    {
        $mysqli = $this->db->getConnection();
        $this->assertInstanceOf('mysqli', $mysqli);
    }

}

