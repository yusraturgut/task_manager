<?php
require_once "../config/db.php";

//SQL bağlantısını döndüren fonksiyon
function get_database_connection() {
    global $conn;
    return $conn;
}

//Görevi kullanıcı ID'si ve görev ID'sine göre getiren fonksiyon
function get_task($user_id, $task_id) {
    $conn = get_database_connection();
    
    if (!is_numeric($task_id)) {
        return [
            "success" => false,
            "message" => "Geçersiz görev ID'si"
        ];
    }

    $task_id = (int)$task_id;
    
    $stmt = mysqli_prepare($conn, "SELECT title, description, status FROM tasks WHERE id=? AND user_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $title, $description, $status);
    
    if (!mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        return [
            "success" => false,
            "message" => "Görev bulunamadı"
        ];
    }
    
    mysqli_stmt_close($stmt);
    return [
        "success" => true,
        "task" => [
            "title" => $title,
            "description" => $description,
            "status" => $status
        ]
    ];
}
//Kullnıcının tüm görevlerini getiren fonksiyon
function get_user_tasks($user_id) {
    $conn = get_database_connection();

    $sql = "SELECT id, title, description, status, created_at FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $sql);

    if(!$stmt) {
        return [
            "success" => false,
            "message" => "Sorgu hazırlanamadı.",
            "tasks" => []
        ];
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [
            "success" => false,
            "message" => "Sorgu yürütülemedi.",
            "tasks" => []
        ];
    }

    $result = mysqli_stmt_get_result($stmt);
    $tasks = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }

    mysqli_stmt_close($stmt);

    return [
        "success" => true,
        "tasks" => $tasks
    ];
}

//Kullanıcı doğrulama fonksiyonu
function authenticate_user($username, $password) {
    $conn = get_database_connection();
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        return ["success" => false, "message" => "Kullanıcı bulunamadı."];
    }

    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return ["success" => true, "message" => "Giriş başarılı!", "user_id" => $user['id']];
    } else {
        return ["success" => false, "message" => "Şifre hatalı."];
}
}

//Kullanıcı kayıt fonksiyonu
function register_user($username, $password) {
    $conn = get_database_connection();
    $message = "";

    if($username === "" || $password === "") {
        return ["success" => false, "message" => "Tüm alanları doldurunuz."];
    }

    //Kullanıcı var mı kontrol et
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return ["success" => false, "message" => "Bu kullanıcı mevcut."];
    }

    //Kullanıcı yoksa ekle
    $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_stmt, "ss", $username, $password);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        mysqli_stmt_close($insert_stmt);
        mysqli_stmt_close($stmt);
        return ["success" => true, "message" => "Kayıt başarılı."];
    } else {
        mysqli_stmt_close($insert_stmt);
        mysqli_stmt_close($stmt);
        return ["success" => false, "message" => "Kayıt sırasında bir hata oluştu."];
    }
}
//Görev ekleme fonksiyonu
function add_task($user_id, $title, $description, $status) {
    global $conn;

    if (mb_strlen($description) > 250) {
        return [
            "success" => false,
            "message" => "Açıklama en fazla 250 karakter olabilir."
        ];
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO tasks (user_id, title, description, status) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $title, $description, $status);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [
            "success" => true,
            "message" => "Görev başarıyla eklendi."
        ];
    } else {
        $error = mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return [
            "success" => false,
            "message" => "Görev eklenirken bir hata oluştu: " . $error
        ];
    }
}

//Görev silme fonksiyonu
 function delete_task($user_id, $task_id) {
    $conn = get_database_connection();

    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [
            "success"=> true,
            "message"=> "Görev başarıyla silindi."
        ];
    } else {
        mysqli_stmt_close($stmt);
        return [
            "success"=> false,
            "message"=> "Görev silinirken bir hata oluştu."
        ];}

    }
//Görev güncelleme fonksiyonu
function update_task($user_id, $task_id, $title, $description, $status) {
    $conn = get_database_connection();

    $sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $title, $description, $status, $task_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [
            "success"=> true,
            "message"=> "Görev başarıyla güncellendi."
        ];
    } else {
        mysqli_stmt_close($stmt);
        return [
            "success"=> false,
            "message"=> "Görev güncellenirken bir hata oluştu."
        ];
    }
}

// Görev sayısını durumuna göre döndüren fonksiyon
function getTaskCount($status) {
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        return 0; // Kullanıcı giriş yapmamışsa
    }

    $userId = $_SESSION['user_id'];
    $conn = get_database_connection();
    $sql = "SELECT COUNT(*) AS count FROM tasks WHERE status = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return 0;
    }

    mysqli_stmt_bind_param($stmt, "si", $status, $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return isset($row['count']) ? (int)$row['count']:0;
}
?>