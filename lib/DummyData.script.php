<?php

require_once(__DIR__.'/../config/config.php');
require_once(__DIR__.'/DB.class.php');
require_once(__DIR__.'/Faker/autoload.php');

$objDB = \ActivatorAdmin\Lib\DB::getInstance();
$db = $objDB->getConnection($config);

$objFaker = \Faker\Factory::create();

for ($i=0; $i<50; $i++) {
    $isactive = 0;
    if ($i%3) {
      $isactive = 1;
    }
    $sql = "INSERT INTO {$config['db']['table']} (isactive, name) VALUES ({$isactive}, \"{$objFaker->name}\")";
    $db->query($sql);
}

