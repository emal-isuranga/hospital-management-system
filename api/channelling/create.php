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
include_once './objects/channelling.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Channelling($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 var_dump($data);
// make sure data is not empty
if(
    !empty($data->patient_id) &&
    !empty($data->patient_name) &&
    !empty($data->doctor_id) &&
    !empty($data->channel_date) &&
    !empty($data->doc_name)
){
 
    // set product property values
    $product->patient_id = $data->patient_id;
    $product->patient_name = $data->patient_name;
    $product->doctor_id = $data->doctor_id;
    $product->doc_name = $data->doc_name;
    $product->channel_date = $data->channel_date;
 
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>