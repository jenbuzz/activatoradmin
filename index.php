<?php

require_once __DIR__ . '/lib/autoload.php';

use ActivatorAdmin\Lib\ConfigHelper;
use ActivatorAdmin\Lib\ModelFacade;
use ActivatorAdmin\Lib\Item;
use ActivatorAdmin\Lib\AuthMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$objConfigHelper = new ConfigHelper();

// Instantiate monolog-Logger.
$objLogger = new Logger('name');
$objLogger->pushHandler(new StreamHandler('docs/activatoradmin.log', Logger::WARNING));

$app = new \Slim\Slim(
    array(
        'custom' => $objConfigHelper,
        'logger' => $objLogger,
        'templates.path' => __DIR__ . '/templates',
    )
);

$app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'Aa-Secret')));

// Authentication check using a custom middleware class.
$app->add(new AuthMiddleware());

/**
 * Render startup template (index)
 */
$app->get('/', function() use($app) {
    $objConfigHelper = $app->config('custom');
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    $app->render('index.tpl', array('baseurl'=>$baseurl));
});

/**
 * Login
 */
$app->get('/login', function() use($app) {
    $objConfigHelper = $app->config('custom');
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    $app->render('login.tpl', array('baseurl'=>$baseurl));
});
$app->post('/login', function() use($app) {
    $objConfigHelper = $app->config('custom');
    $baseurl = $objConfigHelper->get('url', 'baseurl');
    $login = $objConfigHelper->get('login');

    if ($app->request()->post('username')==$login['username'] && 
        hash('sha256', $app->request()->post('password'))==$login['password']) {

        $_SESSION['activatoradmin_user'] = hash('sha256', 'activatoradmin_'.$login['username']);

        $app->redirect($baseurl);
    } else {
        $app->render('login.tpl', array('baseurl'=>$baseurl));
    }
});
$app->get('/logout', function() use($app) {
    unset($_SESSION['activatoradmin_user']);

    $objConfigHelper = $app->config('custom');
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    $app->redirect($baseurl.'login');
});

/**
 * GET all items
 */
$app->get('/items', function() use($app) {
    $arrItems = array();

    $objModelFacade = new ModelFacade(new Item());
    $arrItemObjects = $objModelFacade->loadAll();
    foreach ($arrItemObjects as $objItem) {
        $arrItems[] = $objItem->toArray();
    }

    echo json_encode($arrItems);
});

/**
 * GET a single item
 */
$app->get('/item/:id', function($id) use($app) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objModelFacade = new ModelFacade(new Item());
        $objItem = $objModelFacade->load($id);

        echo json_encode($objItem->toArray());
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * PUT (update) a single item
 */
$app->put('/item/:id', function($id) use($app) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $request = json_decode($app->request->getBody());

        if (is_object($request) && isset($request->isactive)) {
            $objModelFacade = new ModelFacade(new Item());
            $objItem = $objModelFacade->load($id);
            $objItem->setIsActive($request->isactive);
            $objItem->save();
        } else {
            echo json_encode(array('success'=>false));
        }
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * DELETE a single item
 */
$app->delete('/item/:id', function($id) use($app) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objModelFacade = new ModelFacade(new Item());
        $objItem = $objModelFacade->load($id);
        $objItem->delete();

        echo json_encode(array('success'=>true));
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * GET search items
 */
$app->get('/search/:term', function($term) use($app) {
    $term = filter_var($term, FILTER_SANITIZE_STRING);

    $arrItems = array();

    $objModelFacade = new ModelFacade(new Item());
    $arrItemObjects = $objModelFacade->search($term);
    foreach ($arrItemObjects as $objItem) {
        $arrItems[] = $objItem->toArray();
    }

    echo json_encode($arrItems);
});


$app->run();
