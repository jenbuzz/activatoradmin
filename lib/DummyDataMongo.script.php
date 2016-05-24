<?php

require_once __DIR__ . '/autoload.php';

use \ActivatorAdmin\Lib\ConfigHelper;

$objConfigHelper = new ConfigHelper();
$dbConfig = $objConfigHelper->get('mongo');

$username = $dbConfig['user'];
$password = $dbConfig['pass'];

$strAuthentication = 'mongodb://';
if ($username !== '' && $password !== '') {
    $strAuthentication.= $username . ':' . $password . '@';
}
$strAuthentication.= $dbConfig['host'];

$client = new \MongoClient($strAuthentication);
$db = $client->{$dbConfig['name']};
$collection = $db->{$dbConfig['collection']};

$handle = @fopen(__DIR__.'/../docs/db-dummy-data-mongo.txt', 'r');
if ($handle) {
    while (($line = fgets($handle, 4096)) !== false) {
        $arrData = explode(',', str_replace("\n", '', $line));
        $document = array(
            'isactive' => $arrData[0], 
            'name' => $arrData[1]
        );
        $collection->insert($document);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
