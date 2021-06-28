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

  public function get_most_recent_post(){
    return $this->dao->get_most_recent_post();
  }

  public function get_best_rated(){
    return $this->dao->get_best_rated();
  }

  public function add_post($post){

      $data= [
        "recipe_id" => $post['recipe_id'],
        "title" => $post['title'],
        "description" => $post['description'],
        "time_posted" => date(Config::DATE_FORMAT),
        "image" => null,
        "avg_rating" => null
      ];
       return parent::add($data);

  }


}
?>
