<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class RecipeDao extends BaseDao{

  public function __construct(){
    parent::__construct("recipes");
  }

  public function get_recipes($search, $offset, $limit, $order, $total=FALSE){
    list($order_column, $order_direction) = self::parse_order($order);

    $params = [];

    if ($total){
      $query = "SELECT COUNT(*) AS total ";
    }else{
      $query = "SELECT * ";
    }
    $query .= "FROM recipes ";

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
