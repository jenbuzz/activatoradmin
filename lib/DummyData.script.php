<?php

require_once(__DIR__.'/ConfigHelper.class.php');
require_once(__DIR__.'/DB.class.php');
require_once(__DIR__.'/Faker/autoload.php');

$config = new \ActivatorAdmin\Lib\ConfigHelper();
$dbConfig = $config->get('db');

$objDB = \ActivatorAdmin\Lib\DB::getInstance($dbConfig);

$objFaker = \Faker\Factory::create();

for ($i=0; $i<50; $i++) {
    $isactive = 0;
    if ($i%3) {
      $isactive = 1;
    }
    
    $objDB->insert($dbConfig['table'], array('isactive'=>$isactive, 'name'=>$objFaker->name));
}

