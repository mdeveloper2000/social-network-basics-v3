<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Game.php");
    require_once("../dao/GameDAO.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query === "list") {
        session_start();
        $gameDAO = new GameDAO();
        echo json_encode($gameDAO->list());
    }