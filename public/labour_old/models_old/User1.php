<?php

class User{
    private $conn;
    public $id;
    public $Name;
    public $father_husband;
    public $dob;
    public $gender;
    public $mobile;
    public $category_id;
    public $marital_status;
    public $office_id;
    public $esi_number;
    public $district;
    public $pin;
    public $id_card;
    public $user_id;
    public $account_no;
    public $bank_name;
    public $branch_name;
    public $nominee_name;
    public $share;
    public $age;
    public $relationship;
    public $status;
    public $id_card_created_at;
    public $transaction_id;
    public $from_period;
    public $to_period;
    public $fine;
    public $last_subscription;

    public function __construct($db){
        $this->conn = $db;
    }

    public function fetchAll() {
        
        $stmt = $this->conn->prepare('SELECT * FROM user');
        $stmt->execute();
        return $stmt;
    }


    public function fetchOne() {

        $stmt = $this->conn->prepare('
        SELECT 
            u.id, u.Name, u.father_husband, u.dob, u.gender, u.mobile, u.category_id,
            u.marital_status, u.esi_number, u.district, u.pin, u.id_card_created_at, u.id_card, u.office_id,
            bd.account_no, bd.bank_name, bd.branch_name, bd.ifsc_code,
            nm.name AS nominee_name, nm.share, nm.age, nm.relationship, nm.user_id,
            COALESCE(ts.transaction_id, "N/A") AS transaction_id, COALESCE(ts.office_id, "N/A") AS ts_office_id, 
            COALESCE(ts.from_period, "N/A") AS from_period, COALESCE(ts.to_period, "N/A") AS to_period, 
            COALESCE(ts.fine, "N/A") AS fine, COALESCE(ts.last_subscription, "N/A") AS last_subscription, 
            COALESCE(ts.status, "N/A") AS status
        FROM 
            user u 
        LEFT JOIN 
            bank_details bd ON u.id = bd.user_id 
        LEFT JOIN 
            nomination nm ON u.id = nm.user_id 
        LEFT JOIN 
            (
                SELECT 
                    ts.user_id,
                    MAX(ts.status) AS max_status
                FROM 
                    tbl_subscriptions ts
                JOIN 
                    user u ON ts.user_id = u.id
                WHERE  
                    u.id_card = ?
                GROUP BY 
                    ts.user_id
            ) max_ts ON u.id = max_ts.user_id
        LEFT JOIN 
            tbl_subscriptions ts ON u.id = ts.user_id AND ts.status = max_ts.max_status
        WHERE  
            u.id_card = ?
    ');
    
    
        $stmt->bindParam(1, $this->id_card);
        $stmt->bindParam(2, $this->id_card);
        $stmt->execute(); 
        if($stmt->rowCount() > 0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            // $this->ticket = $row['ticket'];
            $this->Name = $row['Name'];
            $this->father_husband = $row['father_husband'];
            $this->dob = $row['dob'];
            $this->gender= $row['gender'];
            $this->mobile = $row['mobile'];
            $this->category_id = $row['category_id'];
            $this->marital_status = $row['marital_status'];
            $this->office_id= $row['office_id'];
            $this->esi_number= $row['esi_number'];
            // $this->present_address= $row['present_address'];
            $this->district= $row['district'];
            $this->pin= $row['pin'];
            $this->id_card_created_at = $row['id_card_created_at'];
            // $this->permanent_address= $row['permanent_address'];
            $this->id_card = $row['id_card'];
            $this->account_no = $row['account_no'];
            $this->bank_name = $row['bank_name'];
            $this->branch_name = $row['branch_name'];
            // $this->ifsc_code = $row['ifsc_code'];
            $this->user_id = $row['user_id'];
            $this->nominee_name = $row['nominee_name'];
            $this->share = $row['share'];
            $this->age = $row['age'];
            $this->relationship = $row['relationship'];
            $this->status= $row['status'];
            $this->transaction_id = $row['transaction_id'];
            $this->from_period = $row['from_period'];
            $this->to_period = $row['to_period'];
            $this->fine = $row['fine'];
            $this->last_subscription = $row['last_subscription'];
            

            return TRUE;

        }
        
        return FALSE;
    }
}
?>