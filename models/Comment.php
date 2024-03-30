<?php

class Comment implements \JsonSerializable {

    private $id;
    private $comment_text;
    private $post_id;
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

    public function getComment_text() {
        return $this->comment_text;
    }

    public function getPost_id() {
        return $this->post_id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setComment_text($comment_text): void {
        $this->comment_text = $comment_text;
    }

    public function setPost_id($post_id): void {
        $this->post_id = $post_id;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

}