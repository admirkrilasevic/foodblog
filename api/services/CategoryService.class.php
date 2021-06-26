<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CategoryDao.class.php';

class CategoryService extends BaseService{

  public function __construct(){
    $this->dao = new CategoryDao();
  }

  public function get_categories($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_categories($search, $offset, $limit, $order, $total);
  }

  public function add_category($category){
    return $this->dao->add_category($category);
  }


}
?>
