<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/RatingDao.class.php';

class RatingService extends BaseService{

  public function __construct(){
    $this->dao = new RatingDao();
  }

  public function get_avg_rating_for_post($id){
    return $this->dao->get_avg_rating_for_post($id);
  }

  public function add_rating($user, $rating){
      if($this->dao->rating_exists($user["id"], $rating["post_id"])){
        throw new Exception("You already gave a rating!");
      }
      $data = [
        "user_id" => $user["id"],
        "post_id" => $rating["post_id"],
        "rating_value" => $rating["rating_value"]
      ];
      return parent::add($data);
  }


}
?>
