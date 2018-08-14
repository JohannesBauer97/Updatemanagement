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

if($input->get("oldpw") === null || $input->get("newpw") === null || $input->get("newpw2") === null){
    header('Location: https://updates.serverlein.de');
    exit;
}

$oldpw = md5($input->get("oldpw"));
$newpw = md5($input->get("newpw"));
$newpw2 = md5($input->get("newpw2"));
$userID = $_SESSION["UserID"];

$result = $db->Query("SELECT * FROM `users` WHERE `password` = '$oldpw'");
if(count($result) > 0){
    if($newpw === $newpw2){
        $result2 = $db->Query("UPDATE `users` SET `password`='$newpw' WHERE `userID` = $userID");
        if(!$result2){
            http_response_code(1337); 
            exit;
        }
    }else{
        http_response_code(1337); 
        exit;
    }
}else{
    http_response_code(1337); 
    exit;
}