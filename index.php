<?php

require_once('lib/Slim/Slim.php');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/**
 * Setup mysql connection
 */
function getConnection() {
  $db = new mysqli( 'localhost', 'root', '', 'activatoradmin' );
  return $db;
}

/**
 * Render startup template (index)
 */
$app->get('/', function() use($app) {
  $app->render('../templates/index.tpl');
});

/**
 * GET all items
 */
$app->get('/items', function() {
  $db = getConnection();
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
$app->get('/item/:id', function($id) {
  $db = getConnection();
  $arrItem = array();

  $sql = "SELECT * FROM items WHERE id=".$db->real_escape_string($id);
  $res = $db->query($sql);
  if($res && $res->num_rows>0) {
    $arrItem = $res->fetch_array(MYSQLI_ASSOC);
  }

  echo json_encode($arrItem);
});

/**
 * PUT (update) a single item
 */
$app->put('/item/:id', function($id) use($app) {
  $db = getConnection();

  $request = json_decode($app->request->getBody());
  
  $sql = "UPDATE items SET active=".$db->real_escape_string($request->active)." WHERE id=".$db->real_escape_string($id);
  $db->query($sql);
});


$app->run();

?>
