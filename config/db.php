<?php
date_default_timezone_set("Europe/Istanbul");
define('DB_HOST',"localhost");
define("DB_NAME","task_manager");
define("DB_USER","root");
define("DB_PASS","");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Bağlantı hatası". $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

