<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../../config/database.php';
 
// instantiate product object
include_once './objects/patients.php';
 
$database = new Database();
$db = $database->getConnection();
 
$patients = new Patients($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
var_dump($data) ;
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->tel) &&
    !empty($data->dob) &&
    !empty($data->nic)
){
 
    // set product property values
    $patients->name = $data->name;
    $patients->email = $data->email;
    $patients->nic = $data->nic;
    $patients->tel = $data->tel;
    $patients->dob = $data->dob;
    $patients->created = date('Y-m-d H:i:s');
 
    // create the product
    if($patients->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "User sing Up succecss"));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to Sing Up."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to Sing Up. Data is incomplete."));
}
?>