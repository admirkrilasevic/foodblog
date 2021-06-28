<?php
/**
 * @OA\Get(path="/admin/comments", tags={"x-admin","comments"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for comments. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List comments from database")
 * )
 */
Flight::route('GET /admin/comments', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  $total = Flight::commentService()->get_comments($search, $offset, $limit, $order, TRUE);
  header('total-comments: ' . $total['total']);
  Flight::json(Flight::commentService()->get_comments($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/comments/comments-for-post/{id}",tags={"comments"},security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", default=1, description="Id of a post"),
 *     @OA\Response(response="200", description="Comments retrieved")
 * )
 */
Flight::route('GET /comments/comments-for-post/@id', function($id){
  Flight::json(Flight::commentService()->get_comments_by_post_id($id));
});

/**
 * @OA\Post(path="/user/comments", tags={"x-user","comments"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Adding a comment", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="post_id", required="true", type="integer", example="1",	description="Id of the post" ),
 *             @OA\Property(property="comment_text", required="true", type="string", example="Recipe is very easy to follow!",	description="Comment" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Added comment")
 * )
 */
Flight::route('POST /user/comments', function(){
  $data = Flight::request()->data->getData();
  Flight::commentService()->add_comment(Flight::get("user"),$data);
  Flight::json(["message"=>"Your comment has been posted"]);
});

/**
 * @OA\Get(path="/user/comments/{id}",tags={"x-user","comments"},security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", default=1, description="Id of a comment"),
 *     @OA\Response(response="200", description="Get comment by id")
 * )
 */
Flight::route('GET /user/comments/@id', function($id){
  Flight::json(Flight::commentService()->get_comment_by_comment_id(Flight::get("user")["id"], $id));
});

/**
 * @OA\Put(path="/user/comments/{id}",tags={"x-user","comments"},security={{"ApiKeyAuth": {}}},
 * @OA\Parameter(type="integer", in="path", name="id", default=1, description="Id of a comment"),
 * @OA\RequestBody(description="Answer info", required=true,
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(
 *        @OA\Property(property="comment_text", type="string", example="Great recipe!", description="Comment")
 *      )
 *    )
 *   ),
 * @OA\Response(response="200", description="Update comment")
 * )
 */
Flight::route('PUT /user/comments/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::commentService()->update_comment(Flight::get("user"), $id, $data));
});
?>
