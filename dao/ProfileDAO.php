<?php

require_once("ConnectionFactory.php");
require_once("../models/Profile.php");

class ProfileDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function save($user_id) {
        try {            
            $sql = "INSERT INTO profiles (user_id) VALUES (:user_id)";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":user_id", $user_id);
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

    public function get($user_id) {
        try {            
            $sql = "SELECT * FROM profiles WHERE user_id = :user_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":user_id", $user_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);                
                $profile = new Profile();
                $profile->setId($row->id);
                $profile->setPicture($row->picture);
                $profile->setAbout($row->about);
                $profile->setBirthday($row->birthday);
                $profile->setBorn_in($row->born_in);
                $profile->setProfession($row->profession);
                return $profile;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function getPicture($user_id) {
        try {            
            $sql = "SELECT picture FROM profiles WHERE user_id = :user_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":user_id", $user_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);
                return $row->picture;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function search($query, $id) {
        $users = array();
        try {
            $sql = "SELECT u.id, u.username, p.picture FROM users u
            INNER JOIN profiles p ON p.user_id = u.id
            WHERE username LIKE :username AND u.id <> :id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":username", "%".$query."%");
            $rs->bindValue(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $user = new stdClass();
                    $user->id = $row->id;
                    $user->username = $row->username;
                    $user->picture = $row->picture;
                    array_push($users, $user);
                }
            }
            return $users;
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

    public function read($id, $session_id) {
        try {            
            $sql = "SELECT u.id, u.username, p.picture, p.about, p.birthday, p.born_in, p.profession FROM users u 
            INNER JOIN profiles p ON p.user_id = u.id
            WHERE p.user_id = :user_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":user_id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);                
                $user = new stdClass;
                $user->id = $row->id;
                $user->username = $row->username;
                $user->picture = $row->picture;
                $user->about = $row->about;
                $user->birthday = $row->birthday;
                $user->born_in = $row->born_in;
                $user->profession = $row->profession;
                $sql = "SELECT sent_id, received_id, accepted FROM invitations 
                        WHERE sent_id = :sent_session_id AND received_id = :received_id
                        OR sent_id = :received_session_id AND received_id = :sent_id";
                $rs = $this->connection->prepare($sql);
                $rs->bindParam(":sent_session_id", $session_id);
                $rs->bindParam(":received_id", $id);
                $rs->bindParam(":received_session_id", $id);
                $rs->bindParam(":sent_id", $session_id);
                $rs->execute();
                $friendship = new stdClass;
                if($rs->rowCount() > 0) {
                    $row = $rs->fetch(PDO::FETCH_OBJ);                
                    $friendship->sent_id = $row->sent_id;
                    $friendship->received_id = $row->received_id;
                    $friendship->accepted = $row->accepted;
                }
                else {
                    $friendship = null;
                }  
                $user->friendship = $friendship;
                return $user;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }
    
    public function update(Profile $profile) {

        try {
            if($profile->getPicture() !== null) {
                $sql = "UPDATE profiles SET picture = :picture WHERE user_id = :user_id";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":picture", $profile->getPicture());
                $rs->bindValue(":user_id", $profile->getUser_id());
                $rs->execute();
                return $profile->getPicture();
            }
            else {
                $sql = "UPDATE profiles SET about = :about, birthday = :birthday, born_in = :born_in, 
                profession = :profession WHERE user_id = :user_id";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":about", $profile->getAbout());
                $rs->bindValue(":user_id", $profile->getUser_id());
                $rs->bindValue(":birthday", $profile->getBirthday());
                $rs->bindValue(":born_in", $profile->getBorn_in());
                $rs->bindValue(":profession", $profile->getProfession());
                $rs->execute();
                return $profile;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;
    }

}