<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";

$user_dao = new UserDao();

$user1 = [
  "password" => "123"
  "name" => "Admir Krilasevic"
];

$user = $user_dao->update_user_by_email("admir@stu.ibu.edu.ba", $user1);

print_r($user);

?>
