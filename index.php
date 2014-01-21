<?php

require_once('lib/Slim/Slim.php');
require_once('config/config.php');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(
  array(
    'custom' => $config,
    'templates.path' => 'templates'
  )
);

/**
 * Setup mysql connection
 */
function getConnection($config) {
  $db = new mysqli( $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name'] );
  return $db;
}

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
  $db = getConnection($app->config('custom'));
  $arrItems = array();

  $sql = "SELECT * FROM items";
  $res = $db->query($sql);
  if($res && $res->num_rows>0) {
    while($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $arrItems[] = $row;
    }
  }

  echo json_encode($arrItems);
});

/**
 * GET a single item
 */
$app->get('/item/:id', function($id) use($app) {
  if($id>0 && is_numeric($id)) {
    $db = getConnection($app->config('custom'));
    $arrItem = array();

    $sql = "SELECT * FROM items WHERE id=".$db->real_escape_string($id);
    $res = $db->query($sql);
    if($res && $res->num_rows>0) {
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
  if($id>0 && is_numeric($id)) {
    $db = getConnection($app->config('custom'));

    $request = json_decode($app->request->getBody());
  
    $sql = "UPDATE items SET active=".$db->real_escape_string($request->active)." WHERE id=".$db->real_escape_string($id);
    $db->query($sql);
  } else {
    echo json_encode(array('success'=>false));
  }

});


$app->run();

?>
