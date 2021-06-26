<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/PostDao.class.php';

class PostService extends BaseService{

  public function __construct(){
    $this->dao = new PostDao();
  }

  public function get_posts($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_posts($search, $offset, $limit, $order, $total);
  }

  public function add_post($post){

      $data= [
        "recipe_id" => $post['recipe_id'],
        "title" => $post['title'],
        "description" => $post['description'],
        "time_posted" => date(Config::DATE_FORMAT),
        "image" => null,
        "view_count" => null,
        "avg_rating" => null
      ];
       return parent::add($data);

  }


}
?>
