<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/RecipeDao.class.php';

class RecipeService extends BaseService{

  private $categoryDao;

  public function __construct(){
    $this->dao = new RecipeDao();
    $this->categoryDao = new CategoryDao();
  }

  public function get_recipes($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_recipes($search, $offset, $limit, $order, $total);
  }

  public function add_recipe($recipe){

      $data= [
        "category_name" => $recipe['category_name'],
        "title" => $recipe['title'],
        "time_req" => $recipe['time_req'],
        "procedure_steps" => $recipe['procedure_steps'],
        "ingredients" => $recipe['ingredients']
      ];

      if(!($this->dao->category_exists($recipe['category_name']))){
        $categoryData = ["name" => $recipe['category_name']];
        $this->categoryDao->add_category($categoryData);
      }

       return parent::add($data);

  }


}
?>
