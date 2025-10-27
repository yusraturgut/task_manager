<?php
require_once "../function/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $user_id = authenticate_user($username, $password);

    if ($user_id) {
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Kullanıcı adı veya şifre hatalı.";
    }
}
?>

<?php include "../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
    <form method="POST">
  <div class="mb-3">
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
</div>
  <button type="submit" class="btn btn-primary">Giriş Yap</button>
  <a href="register.php" class="btn btn-success ms-2">Kayıt Ol</a>
</div>
</form>
</body>
</html>
<?php include "../includes/footer.php"; ?>