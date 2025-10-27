<?php
require_once "../function/functions.php";

require_once "../includes/auth_check.php"; 

$uder_id = $_SESSION['user_id'];
$message = "";
$title = "";
$description = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title === "") {
        $message = "Görev başlığı boş olamaz.";
    } else {
        if (add_task($uder_id, $title, $description)) {
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Görev eklenirken bir hata oluştu.";
        }
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
