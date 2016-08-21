<?php

namespace ActivatorAdmin\Test\PHPunit;

require_once __DIR__ . '/../../lib/autoload.php';

use ActivatorAdmin\Lib\ConfigHelper;
use ActivatorAdmin\Lib\DB;

/**
 * Test the DB class.
 *
 */
class DBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the if the singleton function getInstance() returns MySQL and MongoDB.
     */
    public function testGetInstance()
    {
        $dbMysql = DB::getInstance('mysql');

        $this->assertInstanceOf('\ActivatorAdmin\Lib\MySQL', $dbMysql);

        DB::destroy();

        $dbMongo = DB::getInstance('mongodb');

        $this->assertInstanceOf('\ActivatorAdmin\Lib\Mongo', $dbMongo);

        DB::destroy();
    }
}
