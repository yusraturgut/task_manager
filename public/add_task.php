<?php
require_once "../config/db.php";

//oturum kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$message="";
$title = "";
$description = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $status="pending";

    if($title != " ") {
        $sql = "INSERT INTO tasks(user_id, title, description, status, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt=mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $user_id, $title, $description, $status);

        if(mysqli_stmt_execute($stmt)) {
            header("Location:dashboard.php");
            exit;
        } else {
            $message = "Görev eklenirken bir hta oluştu.";
        }
          mysqli_stmt_close($stmt);
    } else {
        $message = "⚠️ Lütfen görev başlığı girin.";
    }
}
    ?>

<?php include "../includes/header.php"; ?>
<div class="container mt-4">
    <h3>Yeni Görev Ekle</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="mb-3">
            <label class="form-label">Görev Başlığı</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" placeholder="Görev başlığını girin" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Açıklama (isteğe bağlı)</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Detaylar..."><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Görevi Kaydet</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
