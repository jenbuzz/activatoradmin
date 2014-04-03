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
     * Setup a test table before running test cases.
     */
    protected function setUp()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');
        $this->db = DB::getInstance($dbConfig);

        // Create pseudo table for testing
        $mysqli = $this->db->getConnection();
        $sql = "CREATE TABLE IF NOT EXISTS ".$dbConfig['table']."_test ";
        $sql.= "(id INT(11) NOT NULL AUTO_INCREMENT, isactive TINYINT(4), name VARCHAR(255), image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))";
        $mysqli->query($sql);
    }

    /**
     * Drop test table after running testcases.
     */
    protected function tearDown()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');
        $this->db = DB::getInstance($dbConfig);

        // Create pseudo table for testing
        $mysqli = $this->db->getConnection();
        $sql = "DROP TABLE ".$dbConfig['table']."_test";
        $mysqli->query($sql);
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

    public function testSelect()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');
        $this->db = DB::getInstance($dbConfig);
        $mysqli = $this->db->getConnection();

        // Insert test record
        $sqlInsert = "INSERT INTO ".$dbConfig['table']."_test (isactive, name) VALUES (1, 'Test Record 1')";
        $mysqli->query($sqlInsert);

        // Test select function
        $result = $this->db->select($dbConfig['table']."_test");
        $this->assertGreaterThan(0, sizeof($result));
    }

}

