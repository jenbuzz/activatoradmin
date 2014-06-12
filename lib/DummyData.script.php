<?php

require_once __DIR__ . '/autoload.php';

use \ActivatorAdmin\Lib\ConfigHelper;
use \ActivatorAdmin\Lib\DB;

$objConfigHelper = new ConfigHelper();
$dbConfig = $objConfigHelper->get('db');

$objDB = DB::getInstance($dbConfig);

$handle = @fopen(__DIR__.'/../docs/db-dummy-data.sql', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $objDB->query($line);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

/*
$handle = @fopen(__DIR__.'/../docs/db-dummy-data-2.sql', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $objDB->query($line);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
*/
