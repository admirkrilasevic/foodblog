<?php
/**
 * @OA\Get(path="/admin/posts", tags={"x-admin","posts"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for posts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List posts from database")
 * )
 */
Flight::route('GET /admin/posts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  $total = Flight::postService()->get_posts($search, $offset, $limit, $order, TRUE);
  header('total-posts: ' . $total['total']);
  Flight::json(Flight::postService()->get_posts($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/posts", tags={"posts"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for posts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="%2Btime_posted", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List posts from database in chronological order")
 * )
 */
Flight::route('GET /posts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "%2Btime_posted");
  Flight::json(Flight::postService()->get_posts($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/posts/recent", tags={"x-admin","posts"},
 *     @OA\Response(response="200", description="List most recent post")
 * )
 */
Flight::route('GET /posts/recent', function(){
  Flight::json(Flight::postService()->get_most_recent_post());
});

/**
 * @OA\Get(path="/posts/rated", tags={"x-admin","posts"},
 *     @OA\Response(response="200", description="List 4 best rated posts")
 * )
 */
Flight::route('GET /posts/rated', function(){
  Flight::json(Flight::postService()->get_best_rated());
});

/**
 * @OA\Post(path="/admin/posts", tags={"posts", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Adding a post", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="recipe_id", required="true", type="integer", example="1",	description="Id of the recipe" ),
 *    				 @OA\Property(property="title", required="true", type="string", example="Easy cheesecake recipe",	description="Title of the post" ),
 *    				 @OA\Property(property="description", required="true", type="string", example="If you are looking for a quick dessert recipe...",	description="Description of the post" ),
 *    				 @OA\Property(property="image", required="true", type="string", example="cdn...",	description="Link of the image for the post" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Post added.")
 * )
 */
Flight::route('POST /admin/posts', function(){
 $data = Flight::request()->data->getData();
 Flight::postService()->add_post($data);
});

/**
 * @OA\Get(path="/admin/posts", tags={"posts", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for posts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List posts from database")
 * )
 */
Flight::route('GET /admin/posts', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::postService()->get_posts($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/admin/posts/{id}", tags={"posts", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of post"),
 *     @OA\Response(response="200", description="Fetch individual post")
 * )
 */
Flight::route('GET /admin/posts/@id', function($id){
  Flight::json(Flight::postService()->get_by_id($id));
});

/**
 * @OA\Put(path="/admin/posts/{id}", tags={"posts", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic post info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="recipe_id", required="true", type="integer", example="1",	description="Id of the recipe" ),
 *    				 @OA\Property(property="title", required="true", type="string", example="Easy cheesecake recipe",	description="Title of the post" ),
 *    				 @OA\Property(property="description", required="true", type="string", example="If you are looking for a quick dessert recipe...",	description="Description of the post" ),
  *    				 @OA\Property(property="image", required="true", type="string", example="cdn...",	description="Link of the image for the post" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update post based on id")
 * )
 */
Flight::route('PUT /admin/posts/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::postService()->update($id, $data));
});

?>
