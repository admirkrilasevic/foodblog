<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class PostDao extends BaseDao{

  public function __construct(){
    parent::__construct("posts");
  }

  public function get_posts($search, $offset, $limit, $order){
  list($order_column, $order_direction) = self::parse_order($order);

  return $this->query("SELECT *
                       FROM posts
                       WHERE LOWER(title) LIKE CONCAT('%', :title, '%')
                       ORDER BY ${order_column} ${order_direction}
                       LIMIT ${limit} OFFSET ${offset}",
                       ["title" => strtolower($search)]);
  }
}

 ?>
