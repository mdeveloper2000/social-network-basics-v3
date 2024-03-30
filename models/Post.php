<?php

class Post implements \JsonSerializable {

    private $id;
    private $post_text;
    private $post_date;
    private $comments_quantity;
    private $likes_quantity;
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

    public function getPost_text() {
        return $this->post_text;
    }

    public function getPost_date() {
        return $this->post_date;
    }

    public function getComments_quantity() {
        return $this->comments_quantity;
    }

    public function getLikes_quantity() {
        return $this->likes_quantity;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setPost_text($post_text): void {
        $this->post_text = $post_text;
    }

    public function setPost_date($post_date): void {
        $this->post_date = $post_date;
    }

    public function setComments_quantity($comments_quantity): void {
        $this->comments_quantity = $comments_quantity;
    }

    public function setLikes_quantity($likes_quantity): void {
        $this->likes_quantity = $likes_quantity;
    }

    public function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

}