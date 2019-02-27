<?php
// required headers
header("Access-Control-Allow-Origin: localhost/rest-api-authentication-example");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once 'config/database.php';

include_once 'objects/ToDo.php';
 
$database = new Database();
$db = $database->getConnection();
 


$todo = new ToDo($db);
 

$data = json_decode(file_get_contents("php://input"));
 
$todo->idTodo = $data->idTodo;
//$todo->task = $data->task;
//$todo->dateTask = $data->dateTask;
//$todo->idUser = $data->idUser;


// delete the product
if($todo->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Task was deleted."));
}
 
// if unable to delete the product
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete task! Try again"));
}

?>
