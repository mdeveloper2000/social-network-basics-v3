<?php

require_once("ConnectionFactory.php");
require_once("../models/Record.php");

class RecordDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($game_id) {
        $records = array();
        try {
            $sql = "SELECT r.id, r.score, r.game_id,  r.user_id, u.username FROM records r 
            INNER JOIN users u ON r.user_id = u.id 
            WHERE r.game_id = :game_id ORDER BY r.score DESC";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":game_id", $game_id);            
            $rs->execute();            
            if($rs->rowCount() > 0) {                
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $record = new stdClass();
                    $record->id = $row->id;
                    $record->score = $row->score;
                    $record->user_id = $row->user_id;
                    $record->game_id = $row->game_id;
                    $record->username = $row->username;
                    array_push($records, $record);
                }
            }            
            return $records;
        }
        catch(PDOException $exception) {
            $exception->getMessage();
        }
        return null;
    }

    public function save(Record $record) {

        try {
            $sql = "SELECT COUNT(id) AS total FROM records";  
            $rs = $this->connection->query($sql);
            $rs->execute();            
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);
                if($row->total < 10) {
                    $sql = "INSERT INTO records (score, game_id, user_id) VALUES (:score, :game_id, :user_id)";
                    $rs = $this->connection->prepare($sql);
                    $rs->bindValue(":score", $record->getScore());
                    $rs->bindValue(":game_id", $record->getGame_id());
                    $rs->bindValue(":user_id", $record->getUser_id());
                    $rs->execute();
                    if($rs->rowCount() > 0) {
                        return true;
                    }
                }
                else {
                    $sql = "SELECT id FROM records WHERE score = (SELECT MIN(score) FROM records) ORDER BY id DESC LIMIT 1";
                    $rs = $this->connection->query($sql);
                    $rs->execute();
                    if($rs->rowCount() > 0) {
                        $row = $rs->fetch(PDO::FETCH_OBJ);
                        $lastRecordId = $row->id;
                        if($record->getScore() > $lastRecordId) {
                            $this->connection->beginTransaction();
                            $sql = "DELETE FROM records WHERE id = :id";
                            $rs = $this->connection->prepare($sql);
                            $rs->bindParam(":id", $lastRecordId);
                            $rs->execute();
                            if($rs->rowCount() > 0) {
                                $sql = "INSERT INTO records (score, game_id, user_id) VALUES (:score, :game_id, :user_id)";
                                $rs = $this->connection->prepare($sql);
                                $rs->bindValue(":score", $record->getScore());
                                $rs->bindValue(":game_id", $record->getGame_id());
                                $rs->bindValue(":user_id", $record->getUser_id());
                                $rs->execute();
                                if($rs->rowCount() > 0) {
                                    $this->connection->commit();
                                    return true;
                                }
                                else {
                                    $this->connection->rollback();
                                    return null;
                                }
                            }
                        }
                        else {
                            return null;
                        }
                    }
                }
            }            
        }
        catch(PDOException $exception) {
            $exception->getMessage();
        }
        return null;

    }

}