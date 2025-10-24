<?php
require_once "../config/db.php";
session_start();

//Kullanıcı giriş kontrolü
require_once "../includes/auth_check.php"; 

$user_id = $_SESSION["user_id"];

//POST ile silme işlemi
if (!isset($_POST['task_id']) || !is_numeric($_POST['task_id'])) {
        header("Location: dashboard.php");
        exit;
    }

$task_id=(int)$_POST["task_id"];

//Sadece kullanıcı kendi görevini silebilir
$stmt=mysqli_prepare($conn,"DELETE FROM tasks WHERE id=? AND user_id=?");
mysqli_stmt_bind_param($stmt,"ii", $task_id,$user_id );

if(mysqli_stmt_execute($stmt)) {
    mysqli_stmt_execute($stmt);
    header("Location:dashboard.php?msg=task_deleted");
    exit;
} else {
    $message = "Görev silinirken bir hata oluştu.";
}


?>