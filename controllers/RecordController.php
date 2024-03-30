<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Record.php");
    require_once("../dao/RecordDAO.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query === "save") {
        session_start();
        $user_id = $_SESSION["id"];
        $game_id = filter_input(INPUT_POST, trim("game_id"));
        $score = filter_input(INPUT_POST, trim("score"));
        $record = new Record();
        $recordDAO = new RecordDAO();
        $record->setGame_id($game_id);
        $record->setUser_id($user_id);
        $record->setScore($score);
        echo json_encode($recordDAO->save($record));
    }
    if($query === "list") {
        $game_id = filter_input(INPUT_POST, trim("game_id"));        
        $recordDAO = new RecordDAO();
        echo json_encode($recordDAO->list($game_id));
    }