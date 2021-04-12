<?php

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';

Flight::set('flight.log_errors', TRUE);

/* error handling for our API 
Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});

/* utility function for reading query parameters from URL */
Flight::map('query', function($name, $default_value = NULL){
  $request = Flight::request();
  $query_param = @$request->query->getData()[$name];
  $query_param = $query_param ? $query_param : $default_value;
  return $query_param;
});

/* utility function for getting header parameters */
Flight::map('header', function($name){
  $headers = getallheaders();
  return @$headers[$name];
});

/* utility function for generating JWT token */
Flight::map('jwt', function($user){
  $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME), "id" => $user["id"], "r" => $user["role"]], Config::JWT_SECRET);
  return ["token" => $jwt];
});

/* swagger documentation */
Flight::route('GET /swagger', function(){
  $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect('/docs');
});

/* register Business Logic layer services */
Flight::register('userService', 'UserService');

/* include all routes */
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";

Flight::start();

 ?>
