<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, x-csrf-token');
header('Content-Type: application/json');

include_once '../config/connection.php';
include_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Connection();
    $db = $db->connect();

    $user = new User($db);
    
    // Check if Content-Type is application/json
    if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $data = json_decode(file_get_contents("php://input"));
        $id_card = $data->id_card ?? null;
    } else {
        // Otherwise, assume form-data
        $id_card = $_POST['id_card'] ?? null;
    }

    if ($id_card) {
        $user->id_card = $id_card;

        if ($user->fetchOne()) {
            echo json_encode(array(
                'id' => $user->id,
                'id_card' => $user->id_card,
                'Name' => $user->Name,
                'father_husband' => $user->father_husband,
                'dob' => $user->dob,
                'gender' => $user->gender,
                'mobile' => $user->mobile,
                'category_id' => $user->category_id,
                'marital_status' => $user->marital_status,
                'office_id' => $user->office_id,
                'esi_number' => $user->esi_number,
                'district' => $user->district,
                'pin' => $user->pin,
                'account_no' => $user->account_no,
                'bank_name' => $user->bank_name,
                'branch_name' => $user->branch_name,
                'nominee_name' => $user->nominee_name,
                'share' => $user->share,
                'age' => $user->age,
                'relationship' => $user->relationship,
                'transaction_id' => $user->transaction_id,
                'from_period' => $user->from_period,
                'to_period' => $user->to_period,
                'fine' => $user->fine,
                'last_subscription' => $user->last_subscription,
                'status' => $user->status,
                'id_card_created_at' => $user->id_card_created_at,
                'fee_transaction_id'=> $user->fee_transaction_id,
                'fee_office_id' => $user->fee_office_id,
                'fee_status'=> $user->fee_status,
                'fee_amount'=> $user->fee_amount,
                'fee_created_at'=> $user->fee_created_at,
            ));
        } elseif ($user->fetchOneFromParserUser()) {
            echo json_encode(array(
                'id_card' => $user->id_card,
                'Name' => $user->Name,
                'father_husband' => $user->father_husband,
                'mobile' => $user->mobile,
                'account_no' => $user->account_no,
                'bank_name' => $user->bank_name,
                'branch_name' => $user->branch_name,
                'gender' => $user->gender,
                'marital_status' => $user->marital_status,
                'dob' => $user->dob,
                'nominee_name' => $user->nominee_name,
                'relationship' => $user->relationship,
                'share' => $user->share
            ));
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    } else {
        echo json_encode(array('message' => "Error: ID card Number is missing!"));
    }
} else {
    echo json_encode(array('message' => "Error: incorrect Method!"));
}
?>
