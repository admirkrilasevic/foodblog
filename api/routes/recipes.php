<?php
/**
 * @OA\Get(path="/admin/recipes", tags={"x-admin","recipes"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for recipes. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List recipes from database")
 * )
 */
Flight::route('GET /admin/recipes', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  $total = Flight::recipeService()->get_recipes($search, $offset, $limit, $order, TRUE);
  header('total-recipes: ' . $total['total']);
  Flight::json(Flight::recipeService()->get_recipes($search, $offset, $limit, $order));
});

/**
 * @OA\Post(path="/admin/recipes", tags={"recipes", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Adding a recipe", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="category_name", required="true", type="string", example="Dessert",	description="Recipe category" ),
 *    				 @OA\Property(property="title", required="true", type="string", example="Cheesecake",	description="Title of the recipe" ),
 *    				 @OA\Property(property="time_req", required="true", type="string", example="1 hour",	description="Time for the recipe" ),
 *    				 @OA\Property(property="procedure_steps", required="true", type="string", example="Prepare a baking dish...",	description="Procedure the the recipe" ),
 *    				 @OA\Property(property="ingredients", required="true", type="string", example="100g of cream cheese...",	description="Ingredients for the recipe" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Recipe added.")
 * )
 */
Flight::route('POST /admin/recipes', function(){
 $data = Flight::request()->data->getData();
 Flight::recipeService()->add_recipe($data);
});

/**
 * @OA\Get(path="/admin/recipes", tags={"recipes", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for recipes. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List recipes from database")
 * )
 */
Flight::route('GET /admin/recipes', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::recipeService()->get_recipes($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/recipes/{id}", tags={"recipes", "x-admin"},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of recipe"),
 *     @OA\Response(response="200", description="Fetch individual recipe")
 * )
 */
Flight::route('GET /recipes/@id', function($id){
  Flight::json(Flight::recipeService()->get_by_id($id));
});

/**
 * @OA\Put(path="/admin/recipes/{id}", tags={"recipes", "x-admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic recipe info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="category_name", required="true", type="string", example="Dessert",	description="Recipe category" ),
 *    				 @OA\Property(property="title", required="true", type="string", example="Cheesecake",	description="Title of the recipe" ),
 *    				 @OA\Property(property="time_req", required="true", type="string", example="1 hour",	description="Time for the recipe" ),
 *    				 @OA\Property(property="procedure_steps", required="true", type="string", example="Prepare a baking dish...",	description="Procedure the the recipe" ),
 *    				 @OA\Property(property="ingredients", required="true", type="string", example="100g of cream cheese...",	description="Ingredients for the recipe" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update recipe based on id")
 * )
 */
Flight::route('PUT /admin/recipes/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::recipeService()->update($id, $data));
});

?>
