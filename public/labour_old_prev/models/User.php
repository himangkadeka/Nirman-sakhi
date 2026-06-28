<?php

class User{
    private $conn;

    public $id;
    public $ticket;
    public $Name;
    public $father_husband;
    public $dob;
    public $gender;
    public $mobile;
    public $category_id;
    public $marital_status;
    public $office_id;
    public $esi_number;
    public $present_address;
    public $district;
    public $pin;
    public $permanent_address;
    public $id_card;

    public function __construct($db){
        $this->conn = $db;
    }

    public function fetchAll() {
        
        $stmt = $this->conn->prepare('SELECT * FROM user');
        $stmt->execute();
        return $stmt;
    }


    public function fetchOne() {

        $stmt = $this->conn->prepare('SELECT  * FROM user WHERE id_card = ?');
        $stmt->bindParam(1, $this->id_card);
        $stmt->execute();        

        if($stmt->rowCount() > 0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->ticket = $row['ticket'];
            $this->Name = $row['Name'];
            $this->father_husband = $row['father_husband'];
            $this->dob = $row['dob'];
            $this->gender= $row['gender'];
            $this->mobile = $row['mobile'];
            $this->category_id = $row['category_id'];
            $this->marital_status = $row['category_id'];
            $this->office_id= $row['office_id'];
            $this->esi_number= $row['esi_number'];
            $this->present_address= $row['present_address'];
            $this->district= $row['district'];
            $this->pin= $row['pin'];
            $this->permanent_address= $row['permanent_address'];
            $this->id_card = $row['id_card'];

            return TRUE;

        }
        
        return FALSE;
    }
}