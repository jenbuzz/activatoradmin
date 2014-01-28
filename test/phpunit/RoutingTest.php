<?php
namespace ActivatorAdmin\Test\PHPunit;

require_once(__DIR__ . '/../../lib/Slim/Slim.php');

\Slim\Slim::registerAutoloader();

class RoutingTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    public function request($method, $path)
    {
        ob_start();

        \Slim\Environment::mock(array(
            'REQUEST_METHOD' => $method,
            'PATH_INFO' => $path,
            'SERVER_NAME' => 'localhost'
        ));

        require(__DIR__ . '/../../index.php');

        $this->response = $app->response();

        return ob_get_clean();
    }

    public function testIndex()
    {
        $this->request('GET', '/');
        $this->assertEquals(200, $this->response->status());
    }

    public function testItems()
    {
        $this->request('GET', '/items');
        $this->assertEquals(200, $this->response->status());
    }

    public function testGetItem()
    {
        $this->request('GET', '/item/1');
        $this->assertEquals(200, $this->response->status());
    }

    public function testPutItem()
    {
        $this->request('PUT', '/item/1');
        $this->assertEquals(200, $this->response->status());
    }

}

