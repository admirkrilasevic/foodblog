<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class CommentDao extends BaseDao{

  public function __construct(){
    parent::__construct("comments");
  }

  public function get_comments($search, $offset, $limit, $order, $total=FALSE){
    list($order_column, $order_direction) = self::parse_order($order);

    $params = [];

    if ($total){
      $query = "SELECT COUNT(*) AS total ";
    }else{
      $query = "SELECT * ";
    }
    $query .= "FROM comments ";

    if (isset($search)){
        $query .= "WHERE (LOWER(comment_text) LIKE CONCAT('%', :search, '%'))";
        $params['search'] = strtolower($search);
    }

    if ($total){
      return $this->query_unique($query, $params);
    }else{
      $query .="ORDER BY ${order_column} ${order_direction} ";
      $query .="LIMIT ${limit} OFFSET ${offset}";

      return $this->query($query, $params);
    }
  }

  public function get_comments_by_post_id($id){

    $query = "SELECT users.name, comment_text, comment_timestamp
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE post_id = :post_id
            ORDER BY comments.comment_timestamp DESC";


    return $this->query($query, ["post_id"=>$id]);
}

  public function get_comment_by_comment_id($user_id, $id){
      return $this->query_unique("SELECT * FROM comments WHERE id = :id AND user_id = :user_id",["id" => $id, "user_id" => $user_id]);
  }
}

 ?>
