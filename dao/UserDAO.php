<?php

require_once("ConnectionFactory.php");
require_once("../models/User.php");
require_once("../dao/ProfileDAO.php");

class UserDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function login($email, $userpassword) {

        try {            
            $sql = "SELECT * FROM users WHERE email = :email";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":email", $email);
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);
                if(password_verify($userpassword, $row->userpassword)) {
                    $user = new User();
                    $user->setId($row->id);
                    $user->setUsername($row->username);
                    return $user;
                }
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

    public function register(User $user) {

        try {            
            $sql = "SELECT * FROM users WHERE email = :email";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":email", $user->getEmail());
            $rs->execute();
            if($rs->rowCount() > 0) {
                return false;
            }
            else {
                $sql = "INSERT INTO users (username, email, userpassword) VALUES (:username, :email, :userpassword)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":username", $user->getUsername());
                $rs->bindValue(":email", $user->getEmail());
                $rs->bindValue(":userpassword", $user->getUserpassword());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    $last_id = $this->connection->lastInsertId();
                    return $last_id;
                }
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return null;

    }

}