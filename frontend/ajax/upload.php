<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(!isset($_SESSION["UserID"]) || !isset($_FILES['datei']) || !isset($_POST['pid']) || !isset($_POST['version']) || !isset($_POST['changes'])){
    header("Location: https://updates.serverlein.de");
    exit;
}

require_once '../../backend/Input.php';
require_once '../../backend/Database.php';
$input = new UpdateManagement\Input();
$db = new UpdateManagement\Database();

$fname = basename($_FILES['datei']['name']);
$ftype = $_FILES['datei']['type'];
$fsize = $_FILES['datei']['size'];
$ftmpname = $_FILES['datei']['tmp_name'];
$userid = $_SESSION["UserID"];
$pid = filterUserInput($input->get("pid"));
$version = filterUserInput($input->get("version"));
$changes = filterUserInput($input->get("changes"));
$fnewpath = "/home/websites/updates.serverlein/files/" . date("dmYHi") . "_" . $fname;

if(!matchesUserProjekt($pid)){
    http_response_code(1337);
    exit;
}

//überprüfen ob die version klar geht
$sqlVersionCheck = "SELECT * FROM `version` WHERE `projektID` = $pid AND `version` = '$version'";
if(count($db->Query($sqlVersionCheck)) > 0){
    http_response_code(1337);
    exit;
}

//upload
$sql = "INSERT
        INTO
            `dateien`(
                `Name`,
                `Type`,
                `Size`,
                `Path`,
                `ProjektID`
            )
        VALUES(
            '$fname',
            '$ftype',
            $fsize,
            '$fnewpath',
            $pid
        )";

$result = $db->Query($sql);
if($result){
    if(!move_uploaded_file($ftmpname, $fnewpath)){
        http_response_code(1337);
        exit;
    }
}

//version anlegen
$newFileID = $db->LastInsertedID();
$sqlVersionAnlegen = "INSERT
INTO
    `version`(
        `projektID`,
        `version`,
        `DateiID`,
        `changes`
    )
VALUES(
    $pid,
    '$version',
    $newFileID,
    '$changes'
)";
$resultVersionAnlegen = $db->Query($sqlVersionAnlegen);
if(!$resultVersionAnlegen){
    http_response_code(1337);
    exit;
}

function filterUserInput($input,$htmlentities = true){
    $db = new UpdateManagement\Database();
    if($htmlentities){
        $input = htmlentities(mysqli_real_escape_string($db->getLink(),$input));
    }else{
        $input = mysqli_real_escape_string($db->getLink(),$input);
    }
    return $input;
}

function matchesUserProjekt($ProjektID){
    $db = new UpdateManagement\Database();
    $userid = $_SESSION["UserID"];
    $sql = "SELECT * FROM `projekte_user` WHERE `userID` = $userid AND `projektID` = $ProjektID";
    $result = $db->Query($sql);
    if(count($result) > 0){
        return true;
    }
    return false;
}