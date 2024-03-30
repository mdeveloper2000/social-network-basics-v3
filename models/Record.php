<?php

class Record implements \JsonSerializable {

    private $id;
    private $score;
    private $game_id;
    private $user_id;

    public function __construct() {        
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function getScore() {
        return $this->score;
    }

    public function getGame_id() {
        return $this->game_id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setScore($score): void {
        $this->score = $score;
    }

    public function setGame_id($game_id): void {
        $this->game_id = $game_id;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

}