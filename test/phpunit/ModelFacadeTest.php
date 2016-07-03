<?php

namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__ . '/../../lib/autoload.php';

use ActivatorAdmin\Lib\ModelFacade;
use ActivatorAdmin\Lib\Item;
use ActivatorAdmin\Lib\ConfigHelper;
use ActivatorAdmin\Lib\DB;

/**
 * Test the ModelFacade class.
 *
 */
class ModelFacadeTest extends \PHPUnit_Framework_TestCase
{
    private $objModelFacade = false;
    private $dbConfig = false;
    private $mysqli = false;

    /**
     * Setup test table for items.
     * Creates new instance of the class ModelFacade.
     */
    public function setUp()
    {
        // Get database connection.
        $objConfigHelper = new ConfigHelper();
        $this->dbConfig = $objConfigHelper->get('mysql');
        $this->dbConfig['table'] = $this->dbConfig['table']."_test";
        $objDB = DB::getInstance($this->dbConfig);
        $this->mysqli = $objDB->getConnection();

        // Create pseudo table for testing.
        $sql = "CREATE TABLE IF NOT EXISTS ".$this->dbConfig['table']." ";
        $sql.= "(id INT(11) NOT NULL AUTO_INCREMENT, isactive TINYINT(4), name VARCHAR(255), image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))";
        $this->mysqli->query($sql);

        $this->objModelFacade = new ModelFacade(new Item($this->dbConfig));
    }

    /**
     * Drop test table after running testcases.
     */
    protected function tearDown()
    {
        // Create pseudo table for testing.
        $sql = "DROP TABLE ".$this->dbConfig['table'];
        $this->mysqli->query($sql);
    }

    /**
     * Test loading all models.
     */
    public function testLoadAll()
    {
        $arrItems = $this->objModelFacade->loadAll();

        if (is_array($arrItems)) {
            $this->assertTrue(is_array($arrItems));
        } else {
            $this->assertFalse($arrItems);
        }
    }

    /**
     * Test loading a single model.
     */
    public function testLoad()
    {
        // Insert test row in test table.
        $sqlInsert = "INSERT INTO ".$this->dbConfig['table']." (isactive, name, image) VALUES (0, 'Test Item 1', 'image.jpg')";
        $id = $this->mysqli->query($sqlInsert);

        $arrItem = $this->objModelFacade->load($id);

        $this->assertTrue(is_object($arrItem));
    }

    /**
     * Test searching for models with specified name.
     */
    public function testSearch()
    {
        $arrResults = $this->objModelFacade->search('Test');

        $this->assertTrue(is_array($arrResults));
    }

}
