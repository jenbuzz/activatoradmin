#!/bin/bash
phpdoc -t phpdoc/ -d ../test/phpunit/ -f ../lib/AuthMiddleware.class.php -f ../lib/ConfigHelper.class.php -f ../lib/Item.class.php -f ../lib/Model.interface.php -f ../lib/Database.interface.php -f ../lib/DB.class.php -f ../lib/Mongo.class.php -f ../lib/MySQL.class.php -f ../lib/ModelFacade.class.php
