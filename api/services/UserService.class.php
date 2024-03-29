<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';
require_once dirname(__FILE__).'/../clients/SMTPClient.class.php';

class UserService extends BaseService{

  private $smtpClient;

  public function __construct(){
    $this->dao = new UserDao();
    $this->smtpClient = new SMTPClient();
  }

  public function get_users($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_users($search, $offset, $limit, $order, $total);
  }

  public function register($user){

    try {
      $this->dao->beginTransaction();

      $user = parent::add([
        "name" => $user['name'],
        "username" => $user['username'],
        "email" => $user['email'],
        "password" => md5($user['password']),
        "role" => "USER",
        "status" => "pending",
        "token" => md5(random_bytes(16)),
        "created_at" => date(Config::DATE_FORMAT)
      ]);

      $this->dao->commit();

    } catch (\Exception $e) {
      $this->dao->rollBack();
      if (strpos($e->getMessage(), 'users.uq_user_email') !== false) {
        throw new Exception("Account with same email exists in the database", 400, $e);
      }else{
        throw $e;
      }
    }

    $this->smtpClient->send_register_user_token($user);

    return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);
    if (!isset($user['id'])) throw Exception("Invalid token");
    $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);
    Flight::redirect('https://admir-cooks.herokuapp.com/login.html?token=123');
    return $user;
  }

  public function login($user){
    $db_user = $this->dao->get_user_by_email($user["email"]);
    if(!isset($db_user["id"])) throw new Exception("User doesn't exist",400);
    if($db_user["status"] != "ACTIVE") throw new Exception("Account not active",400);
    if($db_user["password"] != md5($user["password"])) throw new Exception("Invalid password",400);
    return $db_user;
  }

  public function reset($user){
    $db_user = $this->dao->get_user_by_token($user["token"]);
    if(!isset($db_user["id"])) throw new Exception("Invalid token",400);
    if (strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_at']) > 300) throw new Exception("Token expired", 400);
    $this->dao->update($db_user['id'], ['password' => md5($user['password']), 'token' => NULL]);
    return $db_user;
  }

  public function forgot($user){
    $db_user = $this->dao->get_user_by_email($user["email"]);
    if(!isset($db_user["id"])) throw new Exception("User doesn't exist",400);
    if (strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_at']) < 300) throw new Exception("Be patient tokens is on his way", 400);
    $db_user = $this->update($db_user['id'], ['token' => md5(random_bytes(16)), 'token_created_at' => date(Config::DATE_FORMAT)]);
    $this->smtpClient->send_user_recovery_token($db_user);
  }

}
?>
