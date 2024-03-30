<?php

require_once("ConnectionFactory.php");
require_once("../models/Invitation.php");

class InvitationDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function send(Invitation $invitation) {
        try {
            $sql = "SELECT sent_id, received_id FROM invitations 
            WHERE sent_id = :sent_id AND received_id = :received_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":sent_id", $invitation->getSent_id());
            $rs->bindValue(":received_id", $invitation->getReceived_id());
            $rs->execute();
            if($rs->rowCount() > 0) {
                return null;
            }
            else {
                $sql = "INSERT INTO invitations (sent_id, received_id) VALUES (:sent_id, :received_id)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":sent_id", $invitation->getSent_id());
                $rs->bindValue(":received_id", $invitation->getReceived_id());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    return true;
                }
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function accept(Invitation $invitation) {
        try {
            $sql = "UPDATE invitations SET accepted = 'YES' WHERE sent_id = :sent_id 
            AND received_id = :received_id";
            $this->connection->beginTransaction();
            $rs = $this->connection->prepare($sql);                    
            $rs->bindValue(":sent_id", $invitation->getSent_id());
            $rs->bindValue(":received_id", $invitation->getReceived_id());
            $rs->execute();
            if($rs->rowCount() > 0) {
                $sql = "INSERT INTO friendships (user_1, user_2) VALUES (:user_1, :user_2)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":user_1", $invitation->getReceived_id());
                $rs->bindValue(":user_2", $invitation->getSent_id());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    $this->connection->commit();
                    return true;
                }
                else {
                    $this->connection->rollback();
                }                
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function cancel(Invitation $invitation) {
        try {
            $sql = "DELETE FROM invitations WHERE sent_id = :sent_id 
            AND received_id = :received_id AND accepted = 'NO'";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":sent_id", $invitation->getSent_id());
            $rs->bindValue(":received_id", $invitation->getReceived_id());
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

    public function list($id) {        
        $invites_sent = array();
        $invites_received = array();
        $list_invites = new stdClass();
        try {
            $sql = "SELECT i.sent_id, u.id, u.username, p.picture FROM invitations i
                INNER JOIN users u ON i.received_id = u.id 
                INNER JOIN profiles p ON p.user_id = u.id
                WHERE i.accepted = 'NO' AND i.sent_id = :id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $user = new stdClass;
                    $user->id = $row->id;
                    $user->username = $row->username;
                    $user->picture = $row->picture;
                    array_push($invites_sent, $user);
                }
            }
            $sql = "SELECT i.sent_id, u.id, u.username, p.picture FROM invitations i
                INNER JOIN users u ON i.sent_id = u.id 
                INNER JOIN profiles p ON p.user_id = u.id
                WHERE i.accepted = 'NO' AND i.received_id = :id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $user = new stdClass;
                    $user->id = $row->id;
                    $user->username = $row->username;
                    $user->picture = $row->picture;
                    array_push($invites_received, $user);
                }
            }
            $list_invites->invites_sent = $invites_sent;
            $list_invites->invites_received = $invites_received;
            return $list_invites;
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

}