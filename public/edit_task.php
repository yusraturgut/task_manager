<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php"; 

// Kullanıcı girişi kontrolü


$user_id = $_SESSION["user_id"];
$message = "";

if (!isset($_GET["id"])||!is_numeric($_GET["id"])) {
    header("Location:dashboard.php");
    exit;
}

$task_id=(int)$_GET["id"];

//Mevcut görev verilerini getir
$stmt = mysqli_prepare($conn, "SELECT title, description, status FROM tasks WHERE id=? AND user_id=?");
mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $title, $description, $status);


if(!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php");
    exit;
}
mysqli_stmt_close($stmt); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_title = trim($_POST['title']);
    $new_description = trim($_POST['description']);
    $new_status = $_POST['status'];

   if ($new_title !== "") {
        $update_sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "sssii", $new_title, $new_description, $new_status, $task_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?msg=task_updated");
            exit;
        } else {
            $message = "Güncelleme sırasında bir hata oluştu.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Görev başlığı boş olamaz.";
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