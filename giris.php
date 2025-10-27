<?php include "partials/index-header.php" ?>
<div class="container text-center">
        <div class="row justify-content-center">
        <navbar class="navbar navbar-expand-lg bg-body-tertiary rounded-4 ">
    <div class="navbar-brand mx-auto ">Görev Kayıt Otomasyonu</div>
    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    </button>
            <div class="rowhead">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link"   href="index.php">Anasayfa </a>
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
        <form>
            <div class="mb-3 text-start">
                <input type="text" class="form-control" placeholder="Kullanıcı Adınız">
            </div>
            <div class="mb-3 text-start">
                <label for="exampleInputPassword1" class="form-label">Şifreniz:</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-success-outline bg-transparent border-success">Giriş Yap</button>
        </form>
        <hr><div class="reg"> Hesabınız yok mu? <a class="reg" href="kayit.php">Kayıt</a> olun.</div>
    </div>
<?php include "partials/index-footer.php" ?>