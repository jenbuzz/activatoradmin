<?php
/**
 * Test the database class.
 * Database: MySQL.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once(__DIR__ . '/../../lib/ConfigHelper.class.php');
require_once(__DIR__ . '/../../lib/DB.class.php');

use \ActivatorAdmin\Lib\ConfigHelper;
use \ActivatorAdmin\Lib\DB;

class DBTest extends \PHPUnit_Framework_TestCase
{
    protected $db;

    /**
     * Connects to a MySQL database and gets an instance of DB.
     * MySQL connection credentials are pulled using class ConfigHelper.
     */
    protected function setUp()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');
        $this->db = DB::getInstance($dbConfig);
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

