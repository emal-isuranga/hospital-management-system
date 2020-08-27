<?php
class Doctor{
  
    // database connection and table name
    private $conn;
    private $table_name = "doctor";
  
    // object properties
    public $id;
    public $name;
    public $nic;
    public $tel;
    public $type;
  
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
                name=:name, nic=:nic, tel=:tel, type=:type";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->nic=htmlspecialchars(strip_tags($this->nic));
    $this->tel=htmlspecialchars(strip_tags($this->tel));
    $this->type=htmlspecialchars(strip_tags($this->type));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":nic", $this->nic);
    $stmt->bindParam(":tel", $this->tel);
    $stmt->bindParam(":type", $this->type);
 
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