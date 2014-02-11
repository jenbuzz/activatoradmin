<?php
namespace ActivatorAdmin\Test\PHPunit;

require_once(__DIR__ . '/../../lib/DB.class.php');

class DBTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $db = \ActivatorAdmin\Lib\DB::getInstance();
        $this->assertInstanceOf('\ActivatorAdmin\Lib\DB', $db);
    }

    public function testGetConnection()
    {
        require_once(__DIR__ . '/../../config/config.php');
        $db = \ActivatorAdmin\Lib\DB::getInstance();
        $mysqli = $db->getConnection($config['db']);
        $this->assertInstanceOf('mysqli', $mysqli);
    }

}

