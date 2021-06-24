<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/RecipeDao.class.php';

class RecipeService extends BaseService{

  public function __construct(){
    $this->dao = new RecipeDao();
  }

  public function get_recipes($search, $offset, $limit, $order){
    if ($search){
      return $this->dao->get_recipes($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function add_recipe($recipe){

      $recipe = [
        "title" => $recipe['title'],
        "time_req" => $recipe['time_req'],
        "procedure" => $recipe['procedure'],
        "ingredients" => $recipe['ingredients'],
      ];

      return parent::add($recipe);
  }


}
?>
