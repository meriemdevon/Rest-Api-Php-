<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/api/updateToDo.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files for decoding jwt will be here
include_once 'config/core.php';
include_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
include_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once 'vendor/firebase/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;


// database connection will be here
// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/ToDo.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$todo = new ToDo($db);

// query products
$stmt = $todo->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $todo_arr=array();
    $todo_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $todo_item=array(
            "idTodo" => $idTodo,
            "task" => $task,
            "dateTask" => $dateTask,
           
            "idUser" => $idUser,
            "userName" => $userName
        );
 
        array_push($todo_arr["records"], $todo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($todo_arr);
}
 
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}




?>