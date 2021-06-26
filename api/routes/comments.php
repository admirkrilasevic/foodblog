<?php
/**
 * @OA\Get(path="/comments/comments-for-post/{id}",tags={"x-user","comments"},security={{"ApiKeyAuth": {}}},
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
