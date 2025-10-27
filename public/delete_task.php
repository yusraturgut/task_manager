<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
require_once "../function/functions.php";

$user_id = $_SESSION["user_id"];

if(!isset($_POST["task_id"])){
    header("Location:dashboard.php");
    exit;
}

$task_id = $_POST["task_id"];
$result = delete_task($user_id, $task_id);

if($result["success"]){
    header("Location: dashboard.php");
    exit;
}else{
    $message = $result["message"];
    header("Location: dashboard.php?error=" . urlencode($message));
    exit;
}

?>