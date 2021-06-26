<?php
/**
 * @OA\Get(path="/ratings/get-avg-rating-for-post/{id}",tags={"ratings"},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", default=1, description="Id of a post"),
 *     @OA\Response(response="200", description="Average rating retrieved")
 * )
 */
Flight::route('GET /ratings/get-avg-rating-for-post/@id', function($id){
  Flight::json(Flight::ratingService()->get_avg_rating_for_post($id));
});

/**
 * @OA\Post(path="/user/ratings", tags={"x-user","ratings"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Adding a rating", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="post_id", required="true", type="integer", example="1",	description="Id of the post" ),
 *             @OA\Property(property="rating_value", required="true", type="string", example="5",	description="Rating value" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Added rating")
 * )
 */
Flight::route('POST /user/ratings', function(){
  $data = Flight::request()->data->getData();
  Flight::ratingService()->add_rating(Flight::get("user"),$data);
  Flight::json(["message"=>"Your rating has been posted"]);
});

?>
