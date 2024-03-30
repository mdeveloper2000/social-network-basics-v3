<?php

class User implements \JsonSerializable {

    private $id;
    private $email;
    private $userpassword;
    private $username;

    public function __construct() {
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUserpassword() {
        return $this->userpassword;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setUserpassword($userpassword): void {
        $this->userpassword = $userpassword;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

}