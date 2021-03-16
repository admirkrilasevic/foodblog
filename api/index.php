<?php

require dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__)."/dao/BaseDao.class.php";

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::start();

 ?>
