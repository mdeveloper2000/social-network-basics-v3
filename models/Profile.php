<?php

class Profile implements \JsonSerializable {

    private $id;
    private $picture;    
    private $about;
    private $birthday;
    private $born_in;
    private $profession;
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

    public function getPicture() {
        return $this->picture;
    }

    public function getAbout() {
        return $this->about;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function getBorn_in() {
        return $this->born_in;
    }

    public function getProfession() {
        return $this->profession;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setPicture($picture): void {
        $this->picture = $picture;
    }

    public function setAbout($about): void {
        $this->about = $about;
    }

    public function setBirthday($birthday): void {
        $this->birthday = $birthday;
    }

    public function setBorn_in($born_in): void {
        $this->born_in = $born_in;
    }

    public function setProfession($profession): void {
        $this->profession = $profession;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

}