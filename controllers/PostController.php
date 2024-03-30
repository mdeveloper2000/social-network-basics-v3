<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Post.php");
    require_once("../models/Comment.php");
    require_once("../dao/PostDAO.php");    

    $query = filter_input(INPUT_POST, "query");
    
    if($query === "list") {
        session_start();
        $user_id = $_SESSION["id"];
        $postDAO = new PostDAO();
        $postsList = $postDAO->list($user_id);
        if($postsList != null) {            
            $posts = array();            
            foreach($postsList as $post) {
                $comments = $postDAO->getComments($post->id);
                $newClass = new stdClass();
                $newClass->post = $post;
                $newClass->comments = $comments;
                array_push($posts, $newClass);                
            }
            echo json_encode($posts);
        }
        else {
            echo json_encode(null);
        }
    }    
    if($query === "get") {
        session_start();
        $id = filter_input(INPUT_POST, trim("id"));
        $postDAO = new PostDAO();
        echo json_encode($postDAO->get($id));
    }
    if($query === "save") {
        session_start();
        $post_text = filter_input(INPUT_POST, trim("post_text"));
        $user_id = $_SESSION["id"];
        $post = new Post();
        $post->setPost_text($post_text);
        $post->setUser_id($user_id);
        $postDAO = new PostDAO();
        echo json_encode($postDAO->save($post));
    }
    if($query === "comment") {
        session_start();
        $comment_text = filter_input(INPUT_POST, trim("comment_text"));
        $post_id = filter_input(INPUT_POST, trim("post_id"));
        $user_id = $_SESSION["id"];
        $comment = new Comment();
        $comment->setComment_text($comment_text);
        $comment->setPost_id($post_id);
        $comment->setUser_id($user_id);
        $postDAO = new PostDAO();
        echo json_encode($postDAO->comment($comment));
    }
    if($query === "like") {
        session_start();
        $post_id = filter_input(INPUT_POST, trim("post_id"));
        $user_id = $_SESSION["id"];
        $like = new Like();
        $like->setUser_id($user_id);
        $like->setPost_id($post_id);
        $postDAO = new PostDAO();
        echo json_encode($postDAO->like($like));
    }