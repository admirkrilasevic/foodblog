<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";

$user_dao = new UserDao();

$user1 = [
  "username"=>"admirkrilasevic",
  "email"=>"admirkrilasevic@gmail.com",
  "password"=>"admir123",
  "admin"=>true
];

$user = $user_dao->add($user1);
print_r($user);

?>
