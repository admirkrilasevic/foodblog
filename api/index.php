<?php

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';
require_once dirname(__FILE__).'/routes/users.php';

Flight::set('flight.log_errors', TRUE);

/* error handling for our API */
Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode());
});

/* utility function for reading query parameters from URL */
Flight::map('query', function($name, $default_value = NULL){
  $request = Flight::request();
  $query_param = @$request->query->getData()[$name];
  $query_param = $query_param ? $query_param : $default_value;
  return $query_param;
});

/* register Business Logic layer services */
Flight::register('userService', 'UserService');

/* include all routes */
require_once dirname(__FILE__)."/routes/users.php";

Flight::start();

 ?>
