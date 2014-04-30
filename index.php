<?php

require_once('lib/ConfigHelper.class.php');
require_once('lib/Slim/Slim.php');
require_once('lib/DB.class.php');

use \ActivatorAdmin\Lib\DB;
use \ActivatorAdmin\Lib\ConfigHelper;

$objConfigHelper = new ConfigHelper();
$dbConfig = $objConfigHelper->get('db');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(
    array(
        'custom' => $objConfigHelper,
        'templates.path' => __DIR__ . '/templates'
    )
);

/**
 * Render startup template (index)
 */
$app->get('/', function() use($app) {
    $app->render('index.tpl');
});

/**
 * GET all items
 */
$app->get('/items', function() use($app, $dbConfig) {
    $objDB = DB::getInstance($dbConfig);
    
    $arrItems = $objDB->select($dbConfig['table']);

    echo json_encode($arrItems);
});

/**
 * GET a single item
 */
$app->get('/item/:id', function($id) use($app, $dbConfig) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objDB = DB::getInstance($dbConfig);
        
	$arrItem = $objDB->select($dbConfig['table'], '*', 'id', $id);
        
        echo json_encode($arrItem);
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * PUT (update) a single item
 */
$app->put('/item/:id', function($id) use($app, $dbConfig) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objDB = DB::getInstance($dbConfig);

        $request = json_decode($app->request->getBody());
 
        if (is_object($request) && isset($request->isactive)) { 
            $objDB->update($dbConfig['table'], array('isactive'=>$request->isactive), 'id', $id);
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
$app->delete('/item/:id', function($id) use($app, $dbConfig) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objDB = DB::getInstance($dbConfig);

        $objDB->delete($dbConfig['table'], 'id', $id);

        echo json_encode(array('success'=>true));
    } else {
        echo json_encode(array('success'=>false));
    }
});


$app->run();

