<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../../backend/Database.php';

$db = new UpdateManagement\Database();

if(!isset($_POST["username"]) || !isset($_POST["password"]) ){
    header('Location: https://updates.serverlein.de');
    exit;
}

$username = mysqli_real_escape_string($db->getLink(),htmlentities($_POST["username"]));
$password = md5($_POST["password"]);
$stay = $_POST["stay"];

$result = $db->Query("SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
if(count($result) > 0){
    $_SESSION["UserName"] = htmlentities($result[0]["username"]);
    $_SESSION["UserID"] = htmlentities($result[0]["userID"]);
    exit;
}else{
    http_response_code(1337);
}