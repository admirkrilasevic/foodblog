<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class RecipeDao extends BaseDao{

  public function __construct(){
    parent::__construct("recipes");
  }

  public function get_recipes($search, $offset, $limit, $order){
  list($order_column, $order_direction) = self::parse_order($order);

  return $this->query("SELECT *
                       FROM recipes
                       WHERE LOWER(title) LIKE CONCAT('%', :title, '%')
                       ORDER BY ${order_column} ${order_direction}
                       LIMIT ${limit} OFFSET ${offset}",
                       ["title" => strtolower($search)]);
  }

  public function category_exists($name){
    $value = $this->query("SELECT COUNT(name) AS total FROM categories WHERE name = :name", ["name" => strtolower($name)]);
    if(($value[0]['total'])!=0){
      return true;
    }
    else{
      return false;
    }
  }
}

 ?>
