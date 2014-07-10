<?php
/**
 * Test the ModelFacade class.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__ . '/../../lib/autoload.php';

use \ActivatorAdmin\Lib\ModelFacade;
use \ActivatorAdmin\Lib\Item;

class ModelFacadeTest extends \PHPUnit_Framework_TestCase
{
    private $objModelFacade;

    public function setUp()
    {
       $this->objModelFacade = new ModelFacade(new Item());
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
        $arrItem = $this->objModelFacade->load(2);

        $this->assertTrue(is_object($arrItem));
    }

    /**
     * Test saving a single model.
     */
    public function testSave()
    {
        // TODO: test save and assert check
    }

    /**
     * Test deleting a single model.
     */
    public function testDelete()
    {
        // TODO: test delete and assert check
    }

}
