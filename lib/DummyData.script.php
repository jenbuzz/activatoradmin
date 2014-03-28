<?php

require_once(__DIR__.'/ConfigHelper.class.php');
require_once(__DIR__.'/DB.class.php');

$config = new \ActivatorAdmin\Lib\ConfigHelper();
$dbConfig = $config->get('db');

$objDB = \ActivatorAdmin\Lib\DB::getInstance($dbConfig);
$mysqli = $objDB->getConnection();

$handle = @fopen(__DIR__.'/../docs/db-dummy-data-2.sql', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $mysqli->query($line);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

