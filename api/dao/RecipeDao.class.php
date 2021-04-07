<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class RecipeDao extends BaseDao{

  public function __construct(){
    parent::__construct("recipes");
  }
}

 ?>
