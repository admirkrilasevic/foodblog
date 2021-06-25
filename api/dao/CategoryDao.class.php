<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class CategoryDao extends BaseDao{

  public function __construct(){
    parent::__construct("categories");
  }

  public function get_categories($search, $offset, $limit, $order){
  list($order_column, $order_direction) = self::parse_order($order);

  return $this->query("SELECT *
                       FROM categories
                       WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                       ORDER BY ${order_column} ${order_direction}
                       LIMIT ${limit} OFFSET ${offset}",
                       ["name" => strtolower($search)]);
  }
}

 ?>
