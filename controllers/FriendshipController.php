<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../dao/FriendshipDAO.php");

    $query = filter_input(INPUT_POST, "query");

    if($query === "list") {
        session_start();
        $id = $_SESSION["id"];
        $friendshipDAO = new FriendshipDAO();
        echo json_encode($friendshipDAO->list($id));
    }
    if($query === "listHomePage") {
        session_start();
        $id = $_SESSION["id"];
        $friendshipDAO = new FriendshipDAO();
        echo json_encode($friendshipDAO->listHomePage($id));
    }