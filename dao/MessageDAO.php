<?php

require_once("ConnectionFactory.php");
require_once("../models/Message.php");

class MessageDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function get($id) {

        $users = array();
        try {            
            $sql = "SELECT DISTINCT u.id, u.username, p.picture FROM messages m 
                    INNER JOIN users u ON u.id = m.to_id 
                    INNER JOIN profiles p ON p.user_id = u.id
                    WHERE m.from_id = :id                    
                        UNION
                    SELECT DISTINCT u.id, u.username, p.picture FROM messages m 
                    INNER JOIN users u ON u.id = m.from_id
                    INNER JOIN profiles p ON p.user_id = u.id                     
                    WHERE m.to_id = :id";                                        
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    if($row->id != $id) {
                        $user = new stdClass();
                        $user->id = $row->id;
                        $user->username = $row->username;
                        $user->picture = $row->picture;                    
                        array_push($users, $user);
                    }
                }
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return $users;

    }

    public function list($id, $id_session) {
        $messages = array();
        try {
            $sql = "SELECT m.message_text, m.message_date, m.from_id, m.to_id FROM messages m 
                    WHERE m.from_id = :id AND m.to_id = :id_session
                    OR m.to_id = :id AND m.from_id = :id_session
                    ORDER BY m.message_date DESC";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":id", $id);
            $rs->bindValue(":id_session", $id_session);
            $rs->bindValue(":id_session", $id);
            $rs->bindValue(":id", $id_session);
            $rs->execute();            
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $message = new Message();
                    $message->setMessage_date($row->message_date);
                    $message->setMessage_text($row->message_text);
                    $message->setFrom_id($row->from_id);
                    $message->setTo_id($row->to_id);
                    array_push($messages, $message);
                }
            }            
            return $messages;
        }
        catch(PDOException $exception) {
            $exception->getMessage();
        }
        return null;
    }

    public function save(Message $message) {

        try {            
            $sql = "INSERT INTO messages (message_text, from_id, to_id, message_date) 
            VALUES (:message_text, :from_id, :to_id, :message_date)";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":message_text", $message->getMessage_text());
            $rs->bindValue(":from_id", $message->getFrom_id());
            $rs->bindValue(":to_id", $message->getTo_id());
            $rs->bindValue(":message_date", $message->getMessage_date());
            $rs->execute();
            if($rs->rowCount() > 0) {
                return true;
            }            
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

}