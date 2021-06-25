<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CategoryDao.class.php';

class CategoryService extends BaseService{

  public function __construct(){
    $this->dao = new CategoryDao();
  }

  public function get_categories($search, $offset, $limit, $order){
    if ($search){
      return $this->dao->get_categories($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function add_category($category){

      $data= [
        "name" => $category['name'],
      ];
       return parent::add($data);

  }


}
?>
