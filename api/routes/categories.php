<?php
/**
 * @OA\Get(path="/admin/categories", tags={"x-admin","categories"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for categories. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List categories from database")
 * )
 */
Flight::route('GET /admin/categories', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  $total = Flight::categoryService()->get_categories($search, $offset, $limit, $order, TRUE);
  header('total-categories: ' . $total['total']);
  Flight::json(Flight::categoryService()->get_categories($search, $offset, $limit, $order));
});

/**
 * @OA\Post(path="/admin/categories", tags={"categories", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Adding a category", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="name", required="true", type="string", example="Desserts",	description="Recipe category" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Category added.")
 * )
 */
Flight::route('POST /admin/categories', function(){
 $data = Flight::request()->data->getData();
 Flight::categoryService()->add_category($data);
});

/**
 * @OA\Get(path="/admin/categories", tags={"categories", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for categories. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List categories from database")
 * )
 */
Flight::route('GET /admin/categories', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::categoryService()->get_categories($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/admin/categories/{id}", tags={"categories", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of category"),
 *     @OA\Response(response="200", description="Fetch individual category")
 * )
 */
Flight::route('GET /admin/categories/@id', function($id){
  Flight::json(Flight::categoryService()->get_by_id($id));
});

/**
 * @OA\Put(path="/admin/categories/{id}", tags={"categories", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic category info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="Dessert",	description="Name of the category" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update category based on id")
 * )
 */
Flight::route('PUT /admin/categories/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::categoryService()->update($id, $data));
});

?>
