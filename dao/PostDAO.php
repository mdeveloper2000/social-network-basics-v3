<?php

require_once("ConnectionFactory.php");
require_once("../models/Post.php");
require_once("../models/Comment.php");
require_once("../models/Like.php");

class PostDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($user_id) {

        $posts = array();
        try {            
            $sql = "SELECT p.id, p.post_text, p.post_date, p.user_id, p.likes_quantity, p.comments_quantity,
                    u.username, profiles.picture, l.id AS liked FROM posts p
                    INNER JOIN users u ON u.id = p.user_id 
                    INNER JOIN profiles ON profiles.user_id = u.id
                    LEFT OUTER JOIN likes l ON l.user_id = :user_id AND l.post_id = p.id
                    WHERE
                    u.id IN (
                        SELECT user_1 FROM friendships WHERE user_2 = :user_id
                            UNION
                        SELECT user_2 FROM friendships WHERE user_1 = :user_id
                    )
                    OR u.id = :user_id";                    
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":user_id", $user_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $post = new stdClass();
                    $post->id = $row->id;
                    $post->post_text = $row->post_text;
                    $post->post_date = date("d/m/Y H:i:s", strtotime($row->post_date));
                    $post->user_id = $row->user_id;
                    $post->likes_quantity = $row->likes_quantity;
                    $post->comments_quantity = $row->comments_quantity;
                    $post->username = $row->username;
                    $post->picture = $row->picture;
                    $post->liked = $row->liked;
                    array_push($posts, $post);
                }
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return $posts;

    }

    public function save(Post $post) {

        try {            
            $sql = "INSERT INTO posts (post_text, user_id) VALUES (:post_text, :user_id)";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":post_text", $post->getPost_text());
            $rs->bindValue(":user_id", $post->getUser_id());                
            $rs->execute();
            if($rs->rowCount() > 0) {
                $last_id = $this->connection->lastInsertId();
                return $last_id;
            }            
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

    public function get($id) {
        
        try {            
            $sql = "SELECT p.id, p.post_text, p.post_date, p.user_id, u.username, profiles.picture, 
            p.likes_quantity, p.comments_quantity FROM posts p
            INNER JOIN users u ON u.id = p.user_id 
            INNER JOIN profiles ON profiles.user_id = u.id
            WHERE p.id = :id";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":id", $id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);
                $post = new stdClass();
                $post->id = $row->id;
                $post->post_text = $row->post_text;
                $post->post_date = date("d/m/Y H:i:s", strtotime($row->post_date));
                $post->user_id = $row->user_id;
                $post->username = $row->username;
                $post->picture = $row->picture;
                $post->likes_quantity = $row->likes_quantity;
                $post->comments_quantity = $row->comments_quantity;
                $post->liked = null;
                return $post;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

    public function comment(Comment $comment) {

        try {            
            $sql = "INSERT INTO comments (comment_text, post_id, user_id) VALUES (:comment_text, :post_id, :user_id)";
            $this->connection->beginTransaction();
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":comment_text", $comment->getComment_text());
            $rs->bindValue(":post_id", $comment->getPost_id());
            $rs->bindValue(":user_id", $comment->getUser_id());
            $rs->execute();
            if($rs->rowCount() > 0) {
                $sql = "UPDATE posts SET comments_quantity = comments_quantity + 1 WHERE id = :id";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":id", $comment->getPost_id());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    $this->connection->commit();
                    return $comment;
                }
                else {
                    $this->connection->rollback();                    
                }
            }            
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

    public function getComments($post_id) {

        $comments = array();
        try {            
            $sql = "SELECT c.id, c.post_id, c.comment_text, c.user_id, 
                    u.id, u.username, profiles.picture
                    FROM comments c
                    INNER JOIN posts p ON p.id = c.post_id 
                    INNER JOIN users u ON u.id = c.user_id
                    INNER JOIN profiles ON profiles.user_id = u.id                   
                    WHERE c.post_id = :post_id ORDER BY c.id DESC";
            $rs = $this->connection->prepare($sql);
            $rs->bindParam(":post_id", $post_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $comment = new stdClass();
                    $comment->id = $row->id;
                    $comment->comment_text = $row->comment_text;
                    $comment->user_id = $row->user_id;
                    $comment->username = $row->username;
                    $comment->picture = $row->picture;
                    array_push($comments, $comment);
                }
                return $comments;
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

    public function like(Like $like) {

        try {            
            $sql = "SELECT id FROM likes WHERE user_id = :user_id AND post_id = :post_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":user_id", $like->getUser_id());
            $rs->bindValue(":post_id", $like->getPost_id());                
            $rs->execute();
            if($rs->rowCount() > 0) {                
                $this->connection->beginTransaction();
                $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":user_id", $like->getUser_id());
                $rs->bindValue(":post_id", $like->getPost_id());                
                $rs->execute();
                if($rs->rowCount() > 0) {                    
                    $sql = "UPDATE posts SET likes_quantity = likes_quantity - 1 WHERE id = :post_id";
                    $rs = $this->connection->prepare($sql);
                    $rs->bindValue(":post_id", $like->getPost_id());
                    $rs->execute();
                    if($rs->rowCount() > 0) {                        
                        $this->connection->commit();
                        return false;
                    }
                    else {
                        $this->connection->rollback();
                        return null;
                    }
                }
            }
            else {
                $this->connection->beginTransaction();
                $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":user_id", $like->getUser_id());
                $rs->bindValue(":post_id", $like->getPost_id());                
                $rs->execute();
                if($rs->rowCount() > 0) {
                    $sql = "UPDATE posts SET likes_quantity = likes_quantity + 1 WHERE id = :post_id";
                    $rs = $this->connection->prepare($sql);
                    $rs->bindValue(":post_id", $like->getPost_id());
                    $rs->execute();
                    if($rs->rowCount() > 0) {
                        $this->connection->commit();
                        return true;
                    }
                    else {
                        $this->connection->rollback();
                        return null;
                    }
                }
            }
        }
        catch(PDOException $exception) {
            echo($exception->getMessage());
        }
        return null;

    }

}