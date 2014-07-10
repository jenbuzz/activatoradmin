<?php
/**
 * Test the Item class.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__ . '/../../lib/autoload.php';

use \ActivatorAdmin\Lib\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test loading an item.
     */
    public function testLoad()
    {
        $objItem = new Item();
        $objItem->load(2);

        // TODO: assert check
    }

    /**
     * Test saving an item.
     */
    public function testSave()
    {
        $objItem = new Item();

        // TODO: save and assert check
    }

    /**
     * Test deleting an item.
     */
    public function testDelete()
    {
        $objItem = new Item();

        // TODO: delete and assert check
    }

    /**
     * Test converting an item to an array.
     */
    public function testToArray()
    {
        $objItem = new Item();
        $objItem->load(2);
        $arrItem = $objItem->toArray();

        $this->assertTrue(is_array($arrItem));
    }

    /**
     * Test getting the id.
     */
    public function testGetId()
    {
        $objItem = new Item();
        $objItem->load(2);

        $this->assertEquals($objItem->getId(), 2);
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
        $objItem = new Item();
        $objItem->load(2);

        $this->assertNotEquals($objItem->getName(), '');
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
        $objItem = new Item();
        $objItem->load(2);

        $this->assertNotEquals($objItem->getIsActive(), '');
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
        $objItem = new Item();
        $objItem->load(2);

        $this->assertNotEquals($objItem->getImage(), '');
    }

}
