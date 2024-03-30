<?php

require_once("ConnectionFactory.php");
require_once("../models/Friendship.php");

class FriendshipDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($id) {
        $invites_accepted = array();
        try {
            $sql = "SELECT u.id, u.username, p.picture FROM friendships f             
            INNER JOIN users u ON u.id = f.user_1 OR u.id = f.user_2
            INNER JOIN profiles p ON p.user_id = u.id
            WHERE f.user_1 = :id OR f.user_2 = :id";           
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    if($row->id !== $id) {
                        $user = new stdClass;
                        $user->id = $row->id;
                        $user->username = $row->username;
                        $user->picture = $row->picture;
                        array_push($invites_accepted, $user);
                    }                    
                }
            }
            return $invites_accepted;
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function listHomePage($id) {
        $friendships = array();
        try {
            $sql = "SELECT u.id, u.username, p.picture FROM users u 
            INNER JOIN profiles p ON p.user_id = u.id 
            WHERE u.id IN
            (
                SELECT f.user_1
                FROM friendships f
                WHERE f.user_2 = :id
            UNION ALL
                SELECT f.user_2
                FROM friendships f
                WHERE f.user_1 = :id
            ) LIMIT 4";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    if($row->id !== $id) {
                        $user = new stdClass;
                        $user->id = $row->id;
                        $user->username = $row->username;
                        $user->picture = $row->picture;
                        array_push($friendships, $user);
                    }                    
                }
            }
            return $friendships;
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

}