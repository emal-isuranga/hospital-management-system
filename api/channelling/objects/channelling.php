<?php
class Channelling{
  
    // database connection and table name
    private $conn;
    private $table_name = "channelling";
  
    // object properties
    public $id;
    public $patient_id;
    public $patient_name;
    public $doctor_id;
    public $doc_name;
    public $channel_date;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
            patient_id=:patient_id, patient_name=:patient_name, doctor_id=:doctor_id, doc_name=:doc_name, channel_date=channel_date";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->patient_id=htmlspecialchars(strip_tags($this->patient_id));
    $this->patient_name=htmlspecialchars(strip_tags($this->patient_name));
    $this->doctor_id=htmlspecialchars(strip_tags($this->doctor_id));
    $this->doc_name=htmlspecialchars(strip_tags($this->doc_name));
    $this->channel_date=htmlspecialchars(strip_tags($this->channel_date));
 
    // bind values
    $stmt->bindParam(":patient_id", $this->patient_id);
    $stmt->bindParam(":patient_name", $this->patient_name);
    $stmt->bindParam(":doctor_id", $this->doctor_id);
    $stmt->bindParam(":doc_name", $this->doc_name);
    $stmt->bindParam(":channel_date", $this->channel_date);

 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function readOne(){
 
    // query to read single record
    $query = "SELECT * 
            FROM
                " . $this->table_name . " 
            WHERE
                id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->name = $row['name'];
    $this->email = $row['email'];
    $this->tel = $row['tel'];
    $this->dob = $row['dob'];
    $this->nic = $row['nic'];
}
}
?>