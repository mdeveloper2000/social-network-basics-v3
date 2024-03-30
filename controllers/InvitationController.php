<?php

    header("Content-Type: application/json; charset=utf-8");
    require_once("../models/Invitation.php");
    require_once("../dao/InvitationDAO.php");

    $query = filter_input(INPUT_POST, "query");

    if($query === "send") {
        session_start();
        $id = filter_input(INPUT_POST, trim("id"));
        if($id !== $_SESSION["id"]) {
            $invitation = new Invitation();
            $invitation->setSent_id($_SESSION["id"]);
            $invitation->setReceived_id($id);
            $invitation = new Invitation();
            $invitation->setSent_id($_SESSION["id"]);
            $invitation->setReceived_id($id);
            $invitationDAO = new InvitationDAO();
            echo json_encode($invitationDAO->send($invitation));
        }
        else {
            echo json_encode(null);
        }
    }
    if($query === "accept") {
        session_start();
        $id = filter_input(INPUT_POST, trim("id"));
        if($id !== $_SESSION["id"]) {
            $invitation = new Invitation();
            $invitation->setSent_id($id);
            $invitation->setReceived_id($_SESSION["id"]);
            $invitationDAO = new InvitationDAO();
            echo json_encode($invitationDAO->accept($invitation));
        }
        else {
            echo json_encode(null);
        }
    }
    if($query === "cancel") {
        session_start();
        $id = filter_input(INPUT_POST, trim("id"));
        if($id !== $_SESSION["id"]) {
            $invitation = new Invitation();
            $invitation->setSent_id($_SESSION["id"]);
            $invitation->setReceived_id($id);
            $invitationDAO = new InvitationDAO();
            echo json_encode($invitationDAO->cancel($invitation));
        }
        else {
            echo json_encode(null);
        }
    }
    if($query === "list") {
        session_start();
        $id = $_SESSION["id"];
        $invitationDAO = new InvitationDAO();
        echo json_encode($invitationDAO->list($id));        
    }
    