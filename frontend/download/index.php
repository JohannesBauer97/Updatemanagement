<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if(!isset($_GET["pid"])){
    header("Location: https://updates.serverlein.de");
    exit;
}

require_once '../../backend/Database.php';
require_once '../../backend/Input.php';

$input = new UpdateManagement\Input();
$db = new UpdateManagement\Database();

$pid = $input->get("pid");

//user will version wissen
if(isset($_GET['version'])){
    $result = $db->Query("SELECT d.*, v.version FROM `dateien` as d INNER JOIN `version` as v ON d.DateiID = v.DateiID AND d.ProjektDatei = 1 AND d.ProjektID = $pid AND d.active = 1");
    if(count($result) <= 0 || !$result){
        echo("Version not found.");
        http_response_code(1337);
    }else{
        echo($result[0]["version"]);
    }
    exit;
}

if(isset($_GET['changes']) && isset($_GET['vid'])){
    $vid = $_GET['vid'];
    $sqlGetVersionInfo = "SELECT * FROM version WHERE versionID = $vid";
    $result = $db->Query($sqlGetVersionInfo);
    if(count($result) <= 0 || !$result){
        exit;
        http_response_code(1337);
    }else{
        echo($result[0]["changes"]);
    }
    exit;
}

$result = $db->Query("SELECT * FROM `dateien` WHERE `ProjektID` = $pid AND `ProjektDatei` = 1 AND `active` = 1 LIMIT 1");

if(count($result) <= 0 || !$result){
    echo("File not found.");
    http_response_code(404);
    exit;
}

$name = $result[0]["Name"];
$path = $result[0]["Path"];
$type = $result[0]["Type"];


header('Content-type: $type');
header("Content-Disposition: attachment; filename=\"$name\"");
readfile($path);