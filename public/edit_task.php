<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php"; 
require_once "../function/functions.php";

$user_id=$_SESSION["user_id"];
$message="";

if(!isset($_GET["id"])||!is_numeric($_GET["id"])){
    header("Location: dashboard.php");
    exit();
}
$task_id=(int)$_GET["id"];
$result = get_task($user_id,$task_id);

if (!$result["success"]) {
    header("Location: dashboard.php");
    exit;
}

$task = $result["task"];
$title = $task["title"];
$description = $task["description"];
$status = $task["status"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_title = $_POST['title'];
    $new_description = $_POST['description'];
    $new_status = $_POST['status'];
    
    $update_result = update_task($user_id, $task_id, $new_title, $new_description, $new_status);
    
    if ($update_result["success"]) {
        header("Location: dashboard.php?msg=task_updated");
        exit;
    } else {
        $message = $update_result["message"];
    }
}

?>

<?php include "../includes/header.php"; ?>

<div class="container mt-4">
    <h3>Görevi Güncelle</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="mb-3">
            <label class="form-label">Görev Başlığı</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Durum</label>
            <select name="status" class="form-control">
                <option value="pending" <?php echo $status === "pending" ? "selected" : ""; ?>>Pending</option>
                <option value="completed" <?php echo $status === "completed" ? "selected" : ""; ?>>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>