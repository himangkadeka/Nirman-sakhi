<?php

class User {
    private $conn;
    public $id;
    public $usr_name;
    public $father_husband;
    public $usr_dob;
    public $usr_gender;
    public $mobile;
    public $category_id;
    public $usr_marital;
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
    public $usr_share;
    public $age;
    public $relationship;
    public $status;
    public $id_card_created_at;
    public $transaction_id;
    public $from_period;
    public $to_period;
    public $fine;
    public $last_subscription;
    public $ticket; 
    public $Account_details;
    public $bank;
    public $bank_branch;
    public $gender;
    public $job;
    public $name_nom;
    public $relation;
    public $share;
    public $fee_amount;
    public $fee_transaction_id;
    public $fee_status;
    public $fee_office_id;
    public $fee_created_at;
    public $idcard_copy;
    // Added for ParserUser data

    public function __construct($db) {
        $this->conn = $db;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare('SELECT * FROM user');
        $stmt->execute();
        return $stmt;
    }

    public function fetchOne() {
        $stmt = $this->conn->prepare('SELECT 
                u.id, u.Name AS usr_name, u.father_husband, u.dob AS usr_dob, u.gender AS usr_gender, u.mobile, u.category_id,
                u.marital_status AS usr_marital, u.esi_number, u.district, u.pin, u.id_card_created_at, u.id_card, u.office_id,
                bd.account_no, bd.bank_name, bd.branch_name AS usr_branch, bd.ifsc_code,
                nm.name AS nominee_name, nm.share as usr_share, nm.age, nm.relationship, nm.user_id,
                COALESCE(ts.transaction_id, "N/A") AS transaction_id, COALESCE(ts.office_id, "N/A") AS ts_office_id, 
                COALESCE(ts.from_period, "N/A") AS from_period, COALESCE(ts.to_period, "N/A") AS to_period, 
                COALESCE(ts.fine, "N/A") AS fine, COALESCE(ts.last_subscription, "N/A") AS last_subscription, 
                COALESCE(ts.status, "N/A") AS status,
                COALESCE(fee.transaction_id, "N/A") AS fee_transaction_id, COALESCE(fee.office_id, "N/A") AS fee_office_id, 
                COALESCE(fee.status, "N/A") AS fee_status, COALESCE(fee.amount, "N/A") AS fee_amount, 
                COALESCE(fee.created_at, "N/A") AS transaction_date,
                id_file.idcard_copy


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

            LEFT JOIN 
                idcard_download_histories id_file ON u.id = id_file.user_id    

            LEFT JOIN 
                tbl_application_fees fee ON u.id = fee.user_id
            WHERE  
                u.id_card = ?
        ');

        $stmt->bindParam(1, $this->id_card);
        $stmt->bindParam(2, $this->id_card);
        $stmt->execute(); 
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->populateUserFields($row);
            return TRUE;
        }

        return FALSE;
    }

    public function fetchOneFromParserUser() {
        $stmt = $this->conn->prepare('SELECT * FROM parser_users WHERE id = ?');
        $stmt->bindParam(1, $this->id_card);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->populateParserUserFields($row);
            return TRUE;
        }
        return FALSE;
    }

    public function checkIdCardExists() {
        $stmt = $this->conn->prepare('SELECT COUNT(*) AS count FROM user WHERE id_card = ?');
        $stmt->bindParam(1, $this->id_card);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['count'] > 0) {
            return TRUE;
        } else {
            $stmt = $this->conn->prepare('SELECT COUNT(*) AS count FROM parser_users WHERE id = ?');
            $stmt->bindParam(1, $this->id_card);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0;
        }
    }

    private function populateUserFields($row) {
        $this->id = $row['id'];
        $this->Name = $row['usr_name'];
        $this->father_husband = $row['father_husband'];
        $this->dob = $row['usr_dob'];
        $this->gender = $row['usr_gender'];
        $this->mobile = $row['mobile'];
        $this->category_id = $row['category_id'];
        $this->marital_status = $row['usr_marital'];
        $this->office_id = $row['office_id'];
        $this->esi_number = $row['esi_number'];
        $this->district = $row['district'];
        $this->pin = $row['pin'];
        $this->id_card_created_at = $row['id_card_created_at'];
        $this->id_card = $row['id_card'];
        $this->account_no = $row['account_no'];
        $this->bank_name = $row['bank_name'];
        $this->branch_name = $row['usr_branch'];
        $this->user_id = $row['user_id'];
        $this->nominee_name = $row['nominee_name'];
        $this->share = $row['usr_share'];
        $this->age = $row['age'];
        $this->relationship = $row['relationship'];
        $this->status = $row['status'];
        $this->transaction_id = $row['transaction_id'];
        $this->from_period = $row['from_period'];
        $this->to_period = $row['to_period'];
        $this->fine = $row['fine'];
        $this->fee_transaction_id = $row['fee_transaction_id'];
        $this->fee_office_id = $row['fee_office_id'];
        $this->fee_status = $row['fee_status'];
        $this->fee_amount = $row['fee_amount'];
        $this->fee_created_at = $row['transaction_date'];
        $this->idcard_copy = $row['idcard_copy'];
    }

    private function populateParserUserFields($row) {
        $this->id = $row['id'];
        // $this->ticket = $row['ticket'];
        $this->Name = $row['Name'];
        $this->father_husband = $row['father_husband'];
        $this->id_card = $row['id'];
        $this->mobile = $row['Mobile'];
        $this->Account_details = $row['Account_details'];
        $this->bank = $row['bank'];
        $this->bank_branch = $row['bank_branch'];
        $this->dob = $row['dob'];
        $this->job = $row['job'];
        $this->gender = $row['gender'];
        $this->marital_status = $row['marital_status'];
        $this->name_nom = $row['name_nom'];
        $this->marital_status = $row['marital_status'];
        $this->name_nom = $row['name_nom'];
        $this->relation = $row['relation'];
        $this->share = $row['share'];

        
    }
}
?>
