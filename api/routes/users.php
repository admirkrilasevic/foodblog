<?php

Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->register($data));
});

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account has been activated"]);

Flight::route('GET /users', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

Flight::route('POST /users', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->add($data));
});

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});
});

?>
