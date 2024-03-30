<?php

class Friendship implements \JsonSerializable {

    private $id;
    private $user_1;
    private $user_2;   

    public function __construct() {        
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function getUser_1() {
        return $this->user_1;
    }

    public function getUser_2() {
        return $this->user_2;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setUser_1($user_1): void {
        $this->user_1 = $user_1;
    }

    public function setUser_2($user_2): void {
        $this->user_2 = $user_2;
    }

}