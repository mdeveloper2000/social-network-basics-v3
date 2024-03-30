<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Message.php");
    require_once("../dao/MessageDAO.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query === "list") {
        session_start();
        $id = $_SESSION["id"];
        $messageDAO = new MessageDAO();
        echo json_encode($messageDAO->get($id));
    }
    if($query == "get") {
        session_start();
        $id_session = $_SESSION["id"];
        $id = filter_input(INPUT_POST, trim("id"));
        $messageDAO = new MessageDAO();        
        echo json_encode($messageDAO->list($id, $id_session));
    }
    if($query === "save") {
        session_start();
        $message_text = filter_input(INPUT_POST, trim("message_text"));
        $from_id = $_SESSION["id"];
        $to_id = filter_input(INPUT_POST, trim("to_id"));
        $message_date = date("Y-m-d H:i:s");
        $message = new Message();
        $message->setMessage_text($message_text);
        $message->setFrom_id($from_id);
        $message->setTo_id($to_id);
        $message->setMessage_date($message_date);
        $messageDAO = new MessageDAO();
        if($messageDAO->save($message)) {
            echo json_encode($message);
        }
        else {
            echo json_encode(null);
        }        
    }