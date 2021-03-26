<?php

//register user
Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->register($data));
});

//confirm registration
Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account has been activated"]);
});

//get users
Flight::route('GET /users', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

//get user by id
Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

//add user
Flight::route('POST /users', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->add($data));
});

//edit user by id
Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});


?>
