<?php
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    include_once '../config/connection.php';
    include_once '../models/User.php';

    if ($_SERVER['REQUEST_METHOD']=== 'GET'){

        $db = new Connection();
        $db = $db->connect();

        $user = new User($db);

        $res = $user->fetchAll();
        $resCount = $res->rowCount();
        
        if($resCount > 0){
            
            $users = array();

            while($row = $res->fetch(PDO::FETCH_ASSOC)) {

                extract($row);
                array_push($users, array( 'id' => $id, 'ticket' => $ticket, 'Name' => $Name, 'id_card' => $id_card));
            }

            echo json_encode($users);
        }else {
            echo json_encode(array('message' => "No records found!"));
        }
    }else {
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }


?>
