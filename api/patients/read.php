<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../../config/database.php';
include_once './objects/patients.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$patients = new Patients($db);
 
// set ID property of record to read
$patients->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$patients->readOne();
 
if($patients->name!=null){
    // create array
    $patients_arr = array(
        "id" =>  $patients->id,
        "name" => $patients->name,
        "email" => $patients->email,
        "nic" => $patients->nic,
        "dob" => $patients->dob,
        "tel" => $patients->tel
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($patients_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}
?>