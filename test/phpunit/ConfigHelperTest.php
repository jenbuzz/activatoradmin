<?php
/**
 * Test the ConfigHelper class.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__ . '/../../lib/autoload.php';

use \ActivatorAdmin\Lib\ConfigHelper;

class ConfigHelperTest extends \PHPUnit_Framework_TestCase
{
    protected $objConfigHelper;

    /**
     * Initializing object ConfigHelper for use in test functions.
     */
    protected function setUp()
    {
        $this->objConfigHelper = new ConfigHelper();
    }

    /**
     * Test getting an entire section from the config.ini as an array.
     */
    public function testGetSection()
    {
        $dbConfig = $this->objConfigHelper->get('db');

        $this->assertGreaterThan(0, sizeof($dbConfig));
        $this->assertArrayHasKey('host', $dbConfig);
    }

    /**
     * Test getting a single key in a section.
     */
    public function testGetSectionKey()
    {
        $dbConfigHost = $this->objConfigHelper->get('db', 'host');

        $this->assertGreaterThan(0, strlen($dbConfigHost));
    }

}
