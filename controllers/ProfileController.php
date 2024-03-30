<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Profile.php");
    require_once("../dao/ProfileDAO.php");

    $query = filter_input(INPUT_POST, "query");

    if($query === "updatePicture") {
        if(isset($_FILES["picture"])) {
            session_start();
            $id = $_SESSION["id"];
            $picture = $_FILES["picture"];
            $profileDAO = new ProfileDAO();
            $profile = new Profile();
            if($picture != null) {
                if(in_array($picture['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                    $currentPicture = $profileDAO->getPicture($id);
                    if($currentPicture !== "default.jpg") {
                        unlink("../pictures/".$currentPicture);
                    }
                    $newPictureName = md5('picture'.md5(time().rand(0, 100000))).'.jpg';
                    $profile->setUser_id($id);
                    $profile->setPicture($newPictureName);
                    move_uploaded_file($_FILES['picture']['tmp_name'], "../pictures/".$newPictureName);
                    $_SESSION["picture"] = $profile->getPicture();
                    echo json_encode($profileDAO->update($profile));
                }
            }
        }
    }
    if($query === "get") {
        session_start();
        $user_id = $_SESSION["id"];
        $profileDAO = new ProfileDAO();
        echo json_encode($profileDAO->get($user_id));
    }
    if($query === "update") {
        session_start();       
        $about = filter_input(INPUT_POST, trim("about"));
        $day = filter_input(INPUT_POST, trim("day"));
        $month = filter_input(INPUT_POST, trim("month"));
        $born_in = filter_input(INPUT_POST, trim("born_in"));
        $profession = filter_input(INPUT_POST, trim("profession"));
        $user_id = $_SESSION["id"];
        $profileDAO = new ProfileDAO();
        $profile = new Profile();
        $profile->setPicture(null);          
        $profile->setAbout($about);
        $profile->setBirthday($day.$month);
        $profile->setBorn_in($born_in);
        $profile->setProfession($profession);
        $profile->setUser_id($user_id);
        echo json_encode($profileDAO->update($profile));
    }
    if($query === "read") {
        session_start();
        $id = filter_input(INPUT_POST, trim("id"));
        if($id !== $_SESSION["id"]) {            
            $profileDAO = new ProfileDAO();
            echo json_encode($profileDAO->read($id, $_SESSION["id"]));
        }
        else {
            echo json_encode(null);
        }
    }
    if($query === "search") {
        session_start();
        $id = $_SESSION["id"];
        $search = filter_input(INPUT_POST, trim("search"));
        $profileDAO = new ProfileDAO();
        echo json_encode($profileDAO->search($search, $id));
    }