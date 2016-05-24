<?php

require_once __DIR__ . '/autoload.php';

use \ActivatorAdmin\Lib\ConfigHelper;

$objConfigHelper = new ConfigHelper();
$dbConfig = $objConfigHelper->get('db');

$m = new \MongoClient();
$db = $m->activatoradmin;
$collection = $db->activatoradmin;

$handle = @fopen(__DIR__.'/../docs/db-dummy-data-mongo.txt', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $arrData = explode(',', str_replace("\n", '', $line));
        $document = array( "isactive" => $arrData[0], "name" => $arrData[1] );
        $collection->insert($document);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
