<?php
require_once "../config/db.php";
// Kullanıcı girişi kontrolü
require_once "../includes/auth_check.php"; 

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username =trim( $_POST["username"]);
    $password =trim( $_POST["password"]);

    if($username === "" || $password === ""){
        $message = "Tüm alanları doldurunuz.";
    }else{
        // Kullanıcı var mı kontrol et
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Bu kullanıcı mevcut.";
        } else {
            
            

            $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "ss", $username,$password);

            if (mysqli_stmt_execute($insert_stmt)) {
                mysqli_stmt_close($insert_stmt);
                header("Location: index.php");
                exit;
            } else {
                $message = "Kayıt sırasında bir hata oluştu.";
            }
        }

        mysqli_stmt_close($stmt);
    }
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
