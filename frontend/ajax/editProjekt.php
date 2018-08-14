<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../../backend/Database.php';
require_once '../../backend/Input.php';
require_once '../../backend/TemplateSystem.php';


$input = new UpdateManagement\Input();

if(!isset($_SESSION["UserID"]) || $input->get("action") === null){
    http_response_code(1337);
    exit;
}

switch($input->get("action")){
    case "saveAllgemeines":
        saveAllgemeines();
        break;
    case "deleteProjekt":
        deleteProjekt();
        break;
    case "setAsProjektFile":
        setAsProjektFile();
        break;
    case "removeAsProjektFile":
        removeAsProjektFile();
        break;
    case "removeFile":
        removeFile();
        break;
    case "getVersionModal":
        getVersionModal();
        break;
}

function getVersionModal(){
    if(!isitset("versionID")){
        http_response_code(1337);
        exit;
    }
    $versionID = $_POST["versionID"];
    $tmp = new UpdateManagement\TemplateSystem();
    $db = new UpdateManagement\Database();
    $tmp->load("version.html");
    
    $sqlGetVersionInfo = "SELECT * FROM version WHERE versionID = $versionID";
    $result = $db->Query($sqlGetVersionInfo)[0];
    $tmp->setVar("Version", $result["version"]);
    $tmp->setVar("Changes", $result["changes"]);
    $tmp->setVar("ChangesLink", "https://updates.serverlein.de/download/index.php?pid=0&changes&vid=" . $versionID);
    
    echo $tmp->Template;
}

function removeFile(){
    if(!isitset("projektid,fileid")){
        http_response_code(1337);
        exit;
    }
    $input = new UpdateManagement\Input();
    $db = new UpdateManagement\Database();
    
    $fileid = filterUserInput($input->get("fileid"));
    $projektid = filterUserInput($input->get("projektid"));
    
    //TODO und matches user = file?
    if(!matchesUserProjekt($projektid)){
        http_response_code(1337);
    }
    
    $result = $db->Query("UPDATE
                                `dateien`
                            SET
                                `active` = 0,
                                `ProjektDatei` = 0
                            WHERE
                                `ProjektID` = $projektid
                            AND
                                `DateiID` = $fileid;");
    if (!$result) {
        http_response_code(1337);
    }
}

function removeAsProjektFile(){
    if(!isitset("projektid,fileid")){
        http_response_code(1337);
        exit;
    }
    $input = new UpdateManagement\Input();
    $db = new UpdateManagement\Database();
    
    $fileid = filterUserInput($input->get("fileid"));
    $projektid = filterUserInput($input->get("projektid"));
    
    //TODO und matches user = file?
    if(!matchesUserProjekt($projektid)){
        http_response_code(1337);
    }
    
    $result = $db->Query("UPDATE
                                `dateien`
                            SET
                                `ProjektDatei` = 0
                            WHERE
                                `ProjektID` = $projektid;");
    if (!$result) {
        http_response_code(1337);
    }
}

function setAsProjektFile(){
    if(!isitset("projektid,fileid")){
        http_response_code(1337);
        exit;
    }
    $input = new UpdateManagement\Input();
    $db = new UpdateManagement\Database();
    
    $fileid = filterUserInput($input->get("fileid"));
    $projektid = filterUserInput($input->get("projektid"));
    
    //TODO und matches user = file?
    if(!matchesUserProjekt($projektid)){
        http_response_code(1337);
    }
    
    $result = $db->Query("UPDATE
                                `dateien`
                            SET
                                `ProjektDatei` = 0
                            WHERE
                                `ProjektID` = $projektid;");
    if (!$result) {
        http_response_code(1337);
        exit;
    }
    
    $result = $db->Query("UPDATE
                                `dateien`
                            SET
                                `ProjektDatei` = 1
                            WHERE
                                `DateiID` = $fileid;");
    if (!$result) {
        http_response_code(1337);
    }
}

function saveAllgemeines(){
    if(!isitset("projektname,projektdesc,projektid")){
        http_response_code(1337);
        exit;
    }
    $input = new UpdateManagement\Input();
    $db = new UpdateManagement\Database();
    
    $projektname = filterUserInput($input->get("projektname"));
    $projektdesc = filterUserInput($input->get("projektdesc"));
    $projektid = filterUserInput($input->get("projektid"));
    
    if(!matchesUserProjekt($projektid)){
        http_response_code(1337);
    }
    
    $result = $db->Query("UPDATE `projekte` SET `Projektname`='$projektname',`Projektbeschreibung`='$projektdesc' WHERE `ProjektID` = $projektid");
    if (!$result) {
        http_response_code(1337);
    }
}

function deleteProjekt(){
    $input = new UpdateManagement\Input();
    if($input->get("projektid") === null){
        http_response_code(1337);
        exit;
    }
    
    $db = new UpdateManagement\Database();
    
    $projektid = filterUserInput($input->get("projektid"));
    
    if(!matchesUserProjekt($projektid)){
        http_response_code(1337);
    }
    
    $result = $db->Query("UPDATE projekte
                            SET active = 0
                            WHERE ProjektID = $projektid");
    if (!$result) {
        http_response_code(1337);
    }
}


function isitset($keystring){
    $keyArray = explode(",", $keystring);
    $input = new UpdateManagement\Input();
    foreach ($keyArray as $key) {
        if($input->get($key) === null){
            return false;
        }
    }
    return true;
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