<?php
require_once "../function/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $result = authenticate_user($username, $password);

    if ($result["success"]) {
        // Giriş başarılı → yönlendir
        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["username"] = $username;
        header("Location: gorev-listesi.php");
        exit;
    } else {
        $error = $result["message"];
    }
}
?>

<?php include "../partials/index-header.php"; ?>

<div class="container text-center">
    <div class="row justify-content-center">
        <navbar class="navbar navbar-expand-lg bg-body-tertiary rounded-4 ">
    <div class="navbar-brand mx-auto">Görev Kayıt Otomasyonu</div>
    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    </button>
            <div class="rowhead">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Anasayfa </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kayit.php">Kayıt Ol</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="giris.php">Giriş Yap</a>
            </li>
        </ul>
    </div>
    </div>
</navbar>
<div class="container-fluid">
    <div class="header-card mt-4">
        <h1 class="text-center mt-1 fs-2">
            <i class="bi bi-patch-check "></i>Giriş Yap
        </h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center py-2">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                 <label for="username" class="form-label">Kullanıcı Adı</label>
  <input 
      type="text" 
      class="form-control"  
      id="username" 
      name="username" 
      placeholder="Kullanıcı adınızı girin" 
      required>
</div>
  <div class="mb-3">
  <label for="password" class="form-label">Şifre</label>
  <input 
      type="password" 
      class="form-control" 
      id="password" 
      name="password" 
      placeholder="Şifrenizi girin" 
      required>
        </form></div>
         <div class="login" button type="submit" class="btn btn-success-outline bg-transparent border-success">Giriş Yap</button></div>
        <hr><div class="reg"> Hesabınız yok mu? <a class="reg" href="kayit.php">Kayıt</a> olun.</div>
    </div>
<?php include "../partials/index-footer.php" ?>