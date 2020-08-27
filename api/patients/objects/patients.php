<?php
class Patients{
  
    // database connection and table name
    private $conn;
    private $table_name = "patients";
  
    // object properties
    public $id;
    public $name;
    public $nic;
    public $email;
    public $tel;
    public $dob;
    public $created;
  
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
                name=:name, nic=:nic, email=:email, tel=:tel, dob=:dob,  created=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->nic=htmlspecialchars(strip_tags($this->nic));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->tel=htmlspecialchars(strip_tags($this->tel));
    $this->dob=htmlspecialchars(strip_tags($this->dob));
    $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":nic", $this->nic);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":tel", $this->tel);
    $stmt->bindParam(":dob", $this->dob);
    $stmt->bindParam(":created", $this->created);
 
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