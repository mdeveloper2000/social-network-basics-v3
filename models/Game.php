<?php

class Game implements \JsonSerializable {

    private $id;
    private $gamename;    

    public function __construct() {        
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function getGamename() {
        return $this->gamename;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setGamename($gamename): void {
        $this->gamename = $gamename;
    }

}