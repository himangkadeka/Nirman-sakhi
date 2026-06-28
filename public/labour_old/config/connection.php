<?php

class Connection {
    private $host = "localhost";
<<<<<<< HEAD
    private $user = "apilabour";
    private $db = "labourolddb";
    private $pwd = "apilabour@123";
=======
    private $user = "labour";
    private $db = "labourold";
    private $pwd = "labour#321";
>>>>>>> 6f7811ba40d3675ed8996a37d45567c4ac7e72a6
    private $conn = NULL;

    public function connect() {

        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exp) {
            echo "Connection Error: " . $exp->getMessage();
        }

        return $this->conn;
    }
}
?>
