<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(!isset($_SESSION["UserID"])){
    header("Location: https://updates.serverlein.de");
    exit;
}
require_once '../../backend/Database.php';
require_once '../../backend/Input.php';

$db = new UpdateManagement\Database();
$input = new UpdateManagement\Input();

if($input->get("projektname") === null || $input->get("projektbeschreibung") === null){
    header('Location: https://updates.serverlein.de');
    exit;
}

$projektname = mysqli_real_escape_string($db->getLink(),htmlentities($input->get("projektname")));
$projektbeschreibung = mysqli_real_escape_string($db->getLink(),htmlentities($input->get("projektbeschreibung")));
$userID = $_SESSION["UserID"];

$result = $db->Query("INSERT INTO `projekte`(`Projektname`, `Projektbeschreibung`) VALUES ('$projektname','$projektbeschreibung')");
if($result){
    $projektID = $db->LastInsertedID();
    $result2 = $db->Query("INSERT INTO `projekte_user`(`userID`, `projektID`) VALUES ($userID,$projektID)");
    if(!$result2){
        http_response_code(1337); 
        exit;
    }
}else{
    http_response_code(1337); 
    exit;
}