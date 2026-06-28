<?php
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    include_once '../config/connection.php';
    include_once '../models/User.php';
    include_once '../models/ParseUser.php';

    if ($_SERVER['REQUEST_METHOD']=== 'GET'){

        $db = new Connection();
        $db = $db->connect();

        $user = new User($db);
        $parserUser = new ParserUser($db);

        $test = $parserUser->fetchIdCommon()->rowCount();
        

        $res = $user->fetchAll();
        $resCount = $res->rowCount();
        $perserUserCount = $parserUser->fetchAll()->rowCount();
        $perserUserCountWithNull = $parserUser->fetchParserUserWithNull()->rowCount();
        $remainingParserUser = $perserUserCount - $perserUserCountWithNull;

        echo "Total user in User Table: ".$resCount;
        echo "\nTotal Data in Parser User Table: ".$perserUserCount;
        echo "\nTotal Data in Parser User Table With Null row: ".$perserUserCountWithNull;
        echo "\nReamaining data (Parser User): ".$remainingParserUser;
        echo "\nID card Number in Common: ".$test;

        // if($resCount > 0){
            
            // $users = array();

            // while($row = $res->fetch(PDO::FETCH_ASSOC)) {

            //     extract($row);
            //     array_push($users, array( 'id' => $id, 'ticket' => $ticket, 'Name' => $Name, 'id_card' => $id_card));
            // }

            // echo json_encode($users);
        // }else {
        //     echo json_encode(array('message' => "No records found!"));
        // }
    }else {
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }


?>