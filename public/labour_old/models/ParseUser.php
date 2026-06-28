<?php

class ParserUser
{
    private $conn;

    public $id;
    public $ticket;
    public $Name;
    public $father_husband;
    public $id_card;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetchAll()
    {

        $stmt = $this->conn->prepare('SELECT * FROM parser_users');
        $stmt->execute();
        return $stmt;
    }




    public function fetchParserUserWithNull()
    {

        $stmt = $this->conn->prepare('SELECT * FROM parser_users WHERE Sl_no=NULL || Sl_no=" "');
        $stmt->execute();
        return $stmt;
    }


    public function fetchIdCommon()
    {
        $stmt = $this->conn->prepare('SELECT * FROM user JOIN parser_users ON user.id_card = parser_users.id');
        $stmt->execute();
        return $stmt;
    }


    public function fetchOne()
    {

        $stmt = $this->conn->prepare('SELECT  * FROM user WHERE id_card = ?');
        $stmt->bindParam(1, $this->id_card);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->ticket = $row['ticket'];
            $this->Name = $row['Name'];
            $this->father_husband = $row['father_husband'];
            $this->id_card = $row['id_card'];

            return TRUE;
        }

        return FALSE;
    }
}
