<?php

require('config/config.php');

require_once('lib/Slim/Slim.php');
require_once('lib/DB.class.php');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(
    array(
        'custom' => $config,
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
$app->get('/items', function() use($app) {
    $config = $app->config('custom');
    $objDB = \ActivatorAdmin\Lib\DB::getInstance($config['db']);
    $arrItems = array();

    $res = $objDB->select($config['db']['table']);
    if ($res && $res->num_rows>0) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $arrItems[] = $row;
        }
    }

    echo json_encode($arrItems);
});

/**
 * GET a single item
 */
$app->get('/item/:id', function($id) use($app) {
    if ($id>0 && is_numeric($id)) {
        $config = $app->config('custom');
        $objDB = \ActivatorAdmin\Lib\DB::getInstance($config['db']);
        $db = $objDB->getConnection();
        $arrItem = array();

        $res = $objDB->select($config['db']['table'], '*', 'id='.$db->real_escape_string($id));
        if ($res && $res->num_rows>0) {
            $arrItem = $res->fetch_array(MYSQLI_ASSOC);
        }

        echo json_encode($arrItem);
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * PUT (update) a single item
 */
$app->put('/item/:id', function($id) use($app) {
    if ($id>0 && is_numeric($id)) {
        $config = $app->config('custom');
        $objDB = \ActivatorAdmin\Lib\DB::getInstance($config['db']);
        $db = $objDB->getConnection();

        $request = json_decode($app->request->getBody());
 
        if (is_object($request) && isset($request->isactive)) { 
            $sql = "UPDATE ".$config['db']['table']." SET isactive=".$db->real_escape_string($request->isactive)." WHERE id=".$db->real_escape_string($id);
            $db->query($sql);
        } else {
            echo json_encode(array('success'=>false));
        }
    } else {
        echo json_encode(array('success'=>false));
    }
});


$app->run();

