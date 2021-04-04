<?php

/* Swagger documentation */
/**
 * @OA\Info(title="Foodblog API", version="1.0")
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/foodblog/api/", description="Development Environment" )
 * )
 */

/**
 * @OA\Get(path="/users", tags={"user"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for users. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /users', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/users/{id}", tags={"user"},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of user"),
 *     @OA\Response(response="200", description="Fetch individual user")
 * )
 */
Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Put(path="/users/{id}", tags={"user"},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic user info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My Test Account",	description="Name of the user" ),
 *    				 @OA\Property(property="username", required="true", type="string", example="testaccount",	description="Username of the user" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="test@account.com",	description="Email of the user" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="testaccount123",	description="Password of the user" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update user based on id")
 * )
 */
Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Post(path="/users/register", tags={"user"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My Test Account",	description="Name of the user" ),
 *    				 @OA\Property(property="username", required="true", type="string", example="testaccount",	description="Username of the user" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="test@account.com",	description="Email of the user" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="testaccount123",	description="Password of the user" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /users/register', function(){
 $data = Flight::request()->data->getData();
 Flight::json(Flight::userService()->register($data));
 Flight::json(["message" => "Confirmation email has been sent. Please confirm your account."]);
});

/**
* @OA\Get(path="/users/confirm/{token}", tags={"user"},
*     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account"),
*     @OA\Response(response="200", description="Message upon successful user activation.")
* )
*/
Flight::route('GET /users/confirm/@token', function($token){
 Flight::userService()->confirm($token);
 Flight::json(["message" => "Your account has been activated"]);
});

/**
 * @OA\Post(path="/users/login", tags={"user"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /users/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->login($data));
});


/**
 * @OA\Post(path="/users/forgot", tags={"user"}, description="Send recovery URL to user's email address",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that recovery link has been sent.")
 * )
 */
Flight::route('POST /users/forgot', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/users/reset", tags={"user"}, description="Reset user's password using recovery token",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", required="true", type="string", example="123",	description="Recovery token" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="123",	description="New password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has changed password.")
 * )
 */
Flight::route('POST /users/reset', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->reset($data);
  Flight::json(["message" => "Your password has been changed"]);
});

?>
