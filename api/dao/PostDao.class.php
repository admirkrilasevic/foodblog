<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class PostDao extends BaseDao{

  public function __construct(){
    parent::__construct("posts");
  }

  public function get_posts($search, $offset, $limit, $order, $total=FALSE){
    list($order_column, $order_direction) = self::parse_order($order);

    $params = [];

    if ($total){
      $query = "SELECT COUNT(*) AS total ";
    }else{
      $query = "SELECT * ";
    }
    $query .= "FROM posts ";

    if (isset($search)){
        $query .= "WHERE (LOWER(title) LIKE CONCAT('%', :search, '%'))";
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

  public function get_most_recent_post(){
      $params = [];
      $query = "SELECT * FROM posts ORDER BY time_posted DESC LIMIT 1";
      return $this->query($query, $params);
  }

  public function get_best_rated(){
      $params = [];
      $query = "SELECT * FROM posts ORDER BY avg_rating DESC LIMIT 4";
      return $this->query($query, $params);
  }
}

?>
