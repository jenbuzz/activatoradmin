<?php

require_once __DIR__.'/autoload.php';

use \ActivatorAdmin\Lib\ConfigHelper;
use \ActivatorAdmin\Lib\Mongo;

$objConfigHelper = new ConfigHelper();
$dbConfig = $objConfigHelper->get('mongo');

$objMongo = Mongo::getInstance($dbConfig);

$handle = @fopen(__DIR__.'/../docs/db-dummy-data-mongo.txt', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $arrData = explode(',', str_replace("\n", '', $line));
        $document = array(
            'isactive' => $arrData[0],
            'name' => $arrData[1],
        );

        $objMongo->insert($document);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
