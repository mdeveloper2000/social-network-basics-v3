<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../dao/UserDAO.php");
    require_once("../dao/ProfileDAO.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query === "login") {
        $email = filter_input(INPUT_POST, trim("email"));
        $userpassword = filter_input(INPUT_POST, "userpassword");
        $csrf_token = filter_input(INPUT_POST, "csrf_token");
        $userDAO = new UserDAO();
        $user = $userDAO->login($email, $userpassword);
        if($user != null && $user->getId() != null) {
            if(!isset($_SESSION)) {
                session_start();                
            }            
            if($csrf_token == $_SESSION['csrf_token']) {
                $profileDAO = new ProfileDAO();
                $picture = $profileDAO->getPicture($user->getId());                
                $_SESSION["id"] = $user->getId();
                $_SESSION["name"] = $user->getUsername();
                $_SESSION["picture"] = $picture;              
                echo json_encode($user);
            }
            else {
                echo json_encode(null);        
            }
        }
        else {
            echo json_encode(null);
        }    
    }
    if($query === "register") {
        $username = filter_input(INPUT_POST, trim("username"));
        $email = filter_input(INPUT_POST, trim("email"));
        $userpassword = filter_input(INPUT_POST, trim("userpassword"));
        $csrf_token = filter_input(INPUT_POST, "csrf_token");
        $userDAO = new UserDAO();
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setUserpassword(password_hash($userpassword, PASSWORD_DEFAULT));
        $last_id = $userDAO->register($user);
        if($last_id !== null) {
            $profileDAO = new ProfileDAO();
            echo json_encode($profileDAO->save($last_id));
        }
    }