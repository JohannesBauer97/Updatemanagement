<?php
session_start();
require_once './modules/Main.php';

$main = new UpdateManagement\Main();
$main->show();

//var_dump($_SESSION);