<?php

class Invitation implements \JsonSerializable {

    private $id;
    private $sent_id;
    private $received_id;
    private $accepted;

    public function __construct() {        
    }

    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function getId() {
        return $this->id;
    }

    public function getSent_id() {
        return $this->sent_id;
    }

    public function getReceived_id() {
        return $this->received_id;
    }

    public function getAccepted() {
        return $this->accepted;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setSent_id($sent_id): void {
        $this->sent_id = $sent_id;
    }

    public function setReceived_id($received_id): void {
        $this->received_id = $received_id;
    }

    public function setAccepted($accepted): void {
        $this->accepted = $accepted;
    }

}