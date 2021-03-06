<?php

namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__.'/../../lib/autoload.php';

use ActivatorAdmin\Lib\ConfigHelper;
use ActivatorAdmin\Lib\DB;
use ActivatorAdmin\Lib\Item;

/**
 * Test the Item class.
 */
class ItemTest extends \PHPUnit\Framework\TestCase
{
    private $dbConfig = false;
    private $mysqli = false;

    /**
     * Setup DB connection for test cases.
     * Changing table in dbConfig to name_test.
     * Creating a test table.
     */
    public function setUp()
    {
        // Get database connection.
        $objConfigHelper = new ConfigHelper();
        $this->dbConfig = $objConfigHelper->get('mysql');
        $this->dbConfig['table'] = $this->dbConfig['table'].'_test';
        $objDB = DB::getInstance('mysql');
        $objDB->setTable = $this->dbConfig['table'];
        $this->mysqli = $objDB->getConnection();

        // Create pseudo table for testing.
        $sql = 'CREATE TABLE IF NOT EXISTS '.$this->dbConfig['table'].' ';
        $sql .= '(id INT(11) NOT NULL AUTO_INCREMENT, isactive TINYINT(4), name VARCHAR(255), image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))';
        $this->mysqli->query($sql);
    }

    /**
     * Drop test table after running testcases.
     */
    protected function tearDown()
    {
        // Create pseudo table for testing.
        $sql = 'DROP TABLE '.$this->dbConfig['table'];
        $this->mysqli->query($sql);
    }

    /**
     * Test loading an item.
     */
    public function testLoad()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getName(), 'Test Item 1');
    }

    /**
     * Test saving an item.
     */
    public function testSave()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);
        $objItem->setName('Test Item 2');
        $objItem->save();
        $objItem->load($id);

        $this->assertEquals($objItem->getName(), 'Test Item 2');
    }

    /**
     * Test deleting an item.
     */
    public function testDelete()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);
        $objItem->delete();

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getName(), '');
    }

    /**
     * Test converting an item to an array.
     */
    public function testToArray()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);
        $arrItem = $objItem->toArray();

        $this->assertTrue(is_array($arrItem));
    }

    /**
     * Test getting the id.
     */
    public function testGetId()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getId(), $id);
    }

    /**
     * Test setting the name.
     */
    public function testSetName()
    {
        $objItem = new Item();
        $objItem->setName('Test Name 1');

        $this->assertEquals($objItem->getName(), 'Test Name 1');
    }

    /**
     * Test getting the name.
     */
    public function testGetName()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getName(), 'Test Item 1');
    }

    /**
     * Test setting the is active attribute.
     */
    public function testSetIsActive()
    {
        $objItem = new Item();
        $objItem->setIsActive(1);

        $this->assertEquals($objItem->getIsActive(), 1);
    }

    /**
     * Test getting the is active attribute.
     */
    public function testGetIsActive()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getIsActive(), 0);
    }

    /**
     * Test setting the image.
     */
    public function testSetImage()
    {
        $objItem = new Item();
        $objItem->setImage('image1.jpg');

        $this->assertEquals($objItem->getImage(), 'image1.jpg');
    }

    /**
     * Test getting the image.
     */
    public function testGetImage()
    {
        // Insert test row in test table.
        $sqlInsert = 'INSERT INTO '.$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $objItem = new Item();
        $objItem->setTable($this->dbConfig['table']);
        $objItem->load($id);

        $this->assertEquals($objItem->getImage(), 'image.jpg');
    }
}
