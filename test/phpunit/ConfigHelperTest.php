<?php
/**
 * Test the ConfigHelper class.
 *
 */
namespace ActivatorAdmin\Test\PHPunit;

require_once(__DIR__ . '/../../lib/ConfigHelper.class.php');

class ConfigHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test getting an entire section from the config.ini as an array.
     */
    public function testGetSection()
    {
        $objConfigHelper = new \ActivatorAdmin\Lib\ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');

        $this->assertGreaterThan(0, sizeof($dbConfig));
        $this->assertArrayHasKey('host', $dbConfig);
    }

    /**
     * Test getting a single key in a section.
     */
    public function testGetSectionKey()
    {
        $objConfigHelper = new \ActivatorAdmin\Lib\ConfigHelper();
        $dbConfigHost = $objConfigHelper->get('db', 'host');

        $this->assertGreaterThan(0, strlen($dbConfigHost));
    }

}

