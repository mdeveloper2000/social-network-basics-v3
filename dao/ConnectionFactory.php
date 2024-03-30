<?php

class ConnectionFactory {

    public static $connection = null;
     
    public static function connect() {

        $database = "socialnetwork";
        $host = "localhost";
        $user = "root";
        $password = "";
        try {
            if(self::$connection === null) {
                self::$connection = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
            }            
        } 
        catch(PDOException $exception) {
            die($exception->getMessage());
        }
        return self::$connection;
        
    }

}