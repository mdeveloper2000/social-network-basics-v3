<?php

require_once("ConnectionFactory.php");
require_once("../models/Game.php");

class GameDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list() {
        $games = array();
        try {
            $sql = "SELECT * FROM games";
            $rs = $this->connection->query($sql);            
            $rs->execute();            
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $game = new Game();
                    $game->setId($row->id);
                    $game->setGamename($row->gamename);
                    array_push($games, $game);
                }
            }            
            return $games;
        }
        catch(PDOException $exception) {
            $exception->getMessage();
        }
        return null;
    }

}