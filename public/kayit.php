<?php
require_once "../config/db.php";
// Kullanıcı girişi kontrolü
require_once "../includes/auth_check.php"; 
require_once "../function/functions.php";

$message = "";
$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $result = register_user($username, $password);
    
    if ($result['success']) {
        $message = $result['message'];
        // Başarılı kayıt - giriş sayfasına yönlendir
        header("Location: giris.php?success=" . urlencode($message));
        exit;
    } else {
        $error = $result['message'];
    }
}
  
?>

<?php include "../partials/index-header.php" ?>
<div class="container text-center">
    <div class="row justify-content-center">
        <navbar class="navbar navbar-expand-lg bg-body-tertiary rounded-4 ">
            <a class="navbar-brand mx-auto">Görev Kayıt Otomasyonu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="rowhead">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Anasayfa </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="kayit.php">Kayıt Ol</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="giris.php">Giriş Yap</a>
                        </li>
                    </ul>
                </div>
            </div>
        </navbar>
        <div class="container-fluid">
            <div class="header-card mt-4">
                <h1 class="text-center mt-1 fs-2">
                    <i class="bi bi-patch-check "></i>Kayıt Ol</h1>
                <form method="POST" class="mt-4">
                    <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                    <div class="mb-3 text-start ">
                        <label for="formGroupExampleInput">Kullanıcı Adınız : </label>
                        <input type="text" name="username" class="form-control" id="formGroupExampleInput"
                               placeholder="Geçerli bir kullanıcı adı giriniz.">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="exampleInputPassword1" class="form-label">Şifreniz:</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn">Kayıt Ol
                    </button>
                </form>
            
                <hr><div class="reg"> Veya <a class="reg" href="giris.php">Giriş</a> yapın.</div>

                </form>

            </div>
            <?php include "../partials/index-footer.php" ?>