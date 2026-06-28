<?php
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');

    header('Access-Control-Allow-Origin: *');

    // Allow the following HTTP methods
    header('Access-Control-Allow-Methods: POST');

    // Allow the following headers during the actual request
    header('Access-Control-Allow-Headers: Content-Type, x-csrf-token');

    // Set the content type for the response
    header('Content-Type: application/json');

    include_once '../config/connection.php';
    include_once '../models/User.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $db = new Connection();
        $db = $db->connect();

        $user = new User($db);
        $data = json_decode(file_get_contents("php://input"));

        if(isset($_POST['id_card'])){

            $user->id_card = $_POST['id_card'];
            // echo json_encode(array('message' => $user->id_card));

            if($user->fetchOne()){

                print_r(json_encode(array(
                    'id' => $user->id,
                    'id_card' => $user->id_card,
                    'ticket' => $user->ticket,
                    'Name' => $user->Name,
                    'father_husband' => $user->father_husband,
                    'dob' => $user->dob,
                    'gender'=> $user->gender,
                    'mobile' => $user->mobile,
                    'category_id' => $user->category_id,
                    'marital_status' => $user->marital_status,
                    'office_id' => $user->office_id,
                    'esi_number' => $user->esi_number,
                    'present_address' => $user->present_address,
                    'district' => $user->district,
                    'pin' => $user->pin,
                    'permanent_address' => $user->permanent_address,
                    'user_id' => $user->user_id,
                    'account_no' => $user->account_no,
                    'bank_name' => $user->bank_name,
                    'branch_name' => $user->branch_name,
                    'ifsc_code' => $user->ifsc_code,
                    'name' => $user->name,
                    'share' => $user->share,
                    'age' => $user->age,
                    'relationship' => $user->relationship,

                )));
            }else{
                echo json_encode(array('message' => "No records found!"));
            }
        }else{
            echo json_encode(array('message' => "Error: ID card Number is missing!"));
        }
    }else{
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }

?>
