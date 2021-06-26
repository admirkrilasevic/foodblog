<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CommentDao.class.php';

class CommentService extends BaseService{

  public function __construct(){
    $this->dao = new CommentDao();
  }

  public function get_comments_by_post_id($id){
    return $this->dao->get_comments_by_post_id($id);
  }

  public function add_comment($user, $comment){
      $data = [
        "user_id" => $user["id"],
        "post_id" => $comment["post_id"],
        "comment_text" => $comment["comment_text"],
        "comment_timestamp" => date(Config::DATE_FORMAT)
      ];
      return parent::add($data);
  }

  public function update_comment($user, $id, $data) {
    $db_comment = $this->dao->get_by_id($id);
    if($db_comment["user_id"] != $user["id"]) throw new Exception("Not your comment!", 403);
    return $this->update($id, $data);
  }

  public function get_comment_by_comment_id($user_id, $id){
    return  $this->dao->get_comment_by_comment_id($user_id, $id);
  }


}
?>
