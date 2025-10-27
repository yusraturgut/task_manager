<?php
require_once "../config/db.php";
// Kullanıcı girişi kontrolü
require_once "../includes/auth_check.php"; 
require_once "../function/functions.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once "../function/functions.php";
    $result = register_user($username, $password);

    $message = $result['message'];
}
  
?>
<?php include "../includes/header.php"; ?>

<div class="container mt-4">
    <h3>Kullanıcı Kayıt</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Kayıt Ol</button>
        <a href="login.php" class="btn btn-secondary">Giriş Yap</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
