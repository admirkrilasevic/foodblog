<?php

require_once dirname(__FILE__).".../BaseDao.class.php";

class RecipeCategoryDao extends BaseDao{

  public function __construct(){
    parent::__construct("recipecategories");
  }
}

 ?>
