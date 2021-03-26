<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

  public function __construct(){
    $this->dao = new UserDao();
  }

  public function get_users($search, $offset, $limit, $order){
    if ($search){
      return $this->dao->get_users($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function register($user){

    try {
      $this->dao->beginTransaction();

      $user = parent::add([
        "name" => $user['name'],
        "username" => $user['username'],
        "email" => $user['email'],
        "password" => $user['password'],
        "admin" => "0",
        "profile_picture" => null,
        "status" => "pending",
        "token" => md5(random_bytes(16)),
        "created_at" => date(Config::DATE_FORMAT)
      ]);

      $this->dao->commit();

    } catch (\Exception $e) {
      $this->dao->rollBack();
      if (str_contains($e->getMessage(), 'users.uq_user_email')) {
        throw new Exception("Account with same email exists in the database", 400, $e);
      }else{
        throw $e;
      }
    }


    // TODO: send email with some token

    return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if (!isset($user['id'])) throw Exception("Invalid token");

    $this->dao->update($user['id'], ["status" => "ACTIVE"]);

    //TODO send email to customer
  }


}
?>
