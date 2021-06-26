<?php
/**
 * @OA\Get(path="/admin/ratings", tags={"x-admin","ratings"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for ratings. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List ratings from database")
 * )
 */
Flight::route('GET /admin/ratings', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  $total = Flight::ratingService()->get_ratings($search, $offset, $limit, $order, TRUE);
  header('total-ratings: ' . $total['total']);
  Flight::json(Flight::ratingService()->get_ratings($search, $offset, $limit, $order));
});

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
