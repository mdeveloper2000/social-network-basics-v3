<?php

class Message implements \JsonSerializable {

    private $id;
    private $message_text;
    private $from_id;
    private $to_id;
    private $message_date;
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

    public function getMessage_text() {
        return $this->message_text;
    }

    public function getFrom_id() {
        return $this->from_id;
    }

    public function getTo_id() {
        return $this->to_id;
    }

    public function getMessage_date() {
        return $this->message_date;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setMessage_text($message_text): void {
        $this->message_text = $message_text;
    }

    public function setFrom_id($from_id): void {
        $this->from_id = $from_id;
    }

    public function setTo_id($to_id): void {
        $this->to_id = $to_id;
    }

    public function setMessage_date($message_date): void {
        $this->message_date = $message_date;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

}