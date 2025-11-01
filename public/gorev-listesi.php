<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php"; 
require_once "../function/functions.php";

$user_id = $_SESSION["user_id"];
$error_message = "";
$message = "";
$title = "";
$description = "";
$status = "";

// Görev sayıları
$pendingCount=getTaskCount('pending'); 
$completedCount=getTaskCount('completed');

// Görevleri çek
$result = get_user_tasks($user_id);
if ($result["success"]) {
    $tasks = $result["tasks"];
} else {
    $error_message = $result['message'] ?? 'Görevler alınamadı.';
    $tasks = [];
}

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];
    $new_title = $_POST['title'];
    $new_description = $_POST['description'];
    $new_status = $_POST['status'];
    
    $update_result = update_task($user_id, $task_id, $new_title, $new_description, $new_status);
    
    if ($update_result["success"]) {
        header("Location: gorev-listesi.php?msg=task_updated");
        exit;
    } else {
        $message = $update_result["message"];
        header("Location: gorev-listesi.php?error=" . urlencode($message));
        exit;
    }
}
// Silme işlemi
 if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["task_id"]) && isset($_POST["action"]) && $_POST["action"] === "delete") {
    $task_id = (int)$_POST["task_id"];
    
    $delete_result = delete_task($user_id, $task_id);
    if ($delete_result["success"]) {
        header("Location: gorev-listesi.php?msg=task_deleted");
        exit();
    } else {
        header("Location: gorev-listesi.php?error=" . urlencode($delete_result["message"]));
        exit();
    }
    }

// Görev ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['title']) && !isset($_POST['action'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description'] ?? '');
    $status = 'pending';

    $insert_result = add_task($user_id, $title, $description, $status);
    if ($insert_result["success"]) {
        header("Location: gorev-listesi.php?msg=task_added");
        exit();
    } else {
        header("Location: gorev-listesi.php?error=" . urlencode($insert_result["message"]));
        exit();
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
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="rowhead">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ">
                        <li class="nav-item d-flex align-items-center">
    <?php if (isset($_SESSION['username'])): ?>
        <span class="nav-link">
            hoşgeldiniz, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a class="nav-link" href="../index.php">Çıkış Yap</a>
    <?php else: ?>
        <a class="nav-link" href="giris.php">Giriş Yap</a>
        <a class="nav-link" href="kayit.php">Kayıt Ol</a>
    <?php endif; ?>
</li>
                    </ul>
                </div>
            </div>
        </navbar>
        
        <div class="container-fluid">
            <div class="header-card mt-4">
                <h1 class="text-center mt-1">
                    <i class="bi bi-check2-circle"></i> Yapılacaklar Listesi
                </h1>
                
                <?php if (isset($_GET['msg'])): ?>
                    <div class="success">
                        <?php 
                        if ($_GET['msg'] === 'task_updated') echo 'Görev başarıyla güncellendi!';
                        if ($_GET['msg'] === 'task_deleted') echo 'Görev başarıyla silindi!';
                        if ($_GET['msg'] === 'task_added') echo 'Görev başarıyla eklendi!';
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="taskForm" class="mt-4">
                    <div class="mb-3">
                        <input type="text"
                               id="taskInput"
                               name="title"
                               class="form-control form-control-lg"
                               placeholder="Yeni görev ekle..."
                               required
                               autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="desc form-label"><i class="bi bi-card-text"></i> Açıklama (isteğe bağlı)</label>
                        <textarea name="description" class="form-control" rows="3" maxlength="250"placeholder="Detaylar..."></textarea>
                    </div>
                    <button class="btn " type="submit">
                        <i class="btn-add bi-plus-circle"></i> Ekle
                    </button>
                </form>
            </div>
            <?php if (empty($tasks)): ?>
                <div class="alert alert-info mt-4">Henüz bir göreviniz yok. Yeni görev ekleyebilirsiniz.</div>
            <?php else: ?>
<<<<<<< HEAD
                 
                 <div class="row mt-4">
                   <div class="status"> 
=======
                 <div class="row mt-4">
                 <div class="status">
>>>>>>> f3240779ff077dc25cb453100c93ee54a997b801
                <div class="col-md-6 mb-3">
                    <div class="waitin">
                        <div class="wait-card">
                            <div class="wait-number" id="pendingCount"><?= $pendingCount ?></div>
                            <div class="wait-label">Bekleyen</div> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="completin">
                        <div class="comp-card">
                            <div class="comp-number" id="completedCount"><?= $completedCount ?></div>
                            <div class="comp-label">Tamamlanan</div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead class="table">
                            <tr>
                                <th>Görev Sırası</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Durum</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $index => $task): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['description']); ?></td>
                                <td>
                                    <?php if ($task['status'] === 'completed'): ?>
                                        <div class="badge-comp">Tamamlandı</div>
                                    <?php else: ?>
                                        <div class="badge-wait">Bekliyor</div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $task['created_at']; ?></td>
                                <td>
                                    <!-- Düzenle Butonu -->
                                    <button type="btn-re button" 
                                            class="btn-re btn-sm btn-primary me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?php echo $task['id']; ?>">
                                        <i class="btn-re bi-pencil"></i> Düzenle
                                    </button>
                                    
                                    <!-- Silme Formu -->
                                    <form method="POST" action="gorev-listesi.php" style="display:inline;">
                                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn-del" 
                                                onclick="return confirm('Bu görevi silmek istediğinize emin misiniz?');">
                                            <i class="btn-del bi-trash"></i> Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

           
        </div>
    </div>
</div>

<?php if (!empty($tasks)): ?>
    <?php foreach ($tasks as $task): ?>
    <div class="modal fade" 
         id="editModal<?php echo $task['id']; ?>" 
         tabindex="-1" 
         aria-labelledby="editModalLabel<?php echo $task['id']; ?>" 
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?php echo $task['id']; ?>">
                        <i class="bi bi-pencil-square"></i> Görev Düzenle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" action="gorev-listesi.php">
                    <div class="modal-body">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="action" value="update">
                        <div class="mb-3">
                            <label for="editTitle<?php echo $task['id']; ?>" class="form-label  fw-bold">
                                <i class="bi bi-card-text"></i> Başlık
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="editTitle<?php echo $task['id']; ?>" 
                                   name="title" 
                                   value="<?php echo htmlspecialchars($task['title']); ?>" 
                                   required
                                   autocomplete="off">
                        </div>
                        
                        <div class="mb-3">
                            <label for="editDescription<?php echo $task['id']; ?>" class="form-label fw-bold">
                                <i class="bi bi-text-paragraph"></i> Açıklama
                            </label>
                            <textarea class="form-control" 
                                      id="editDescription<?php echo $task['id']; ?>" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Detaylar..."><?php echo htmlspecialchars($task['description']); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editStatus<?php echo $task['id']; ?>" class="form-label fw-bold">
                                <i class="bi bi-check-circle"></i> Durum
                            </label>
                            <select class="form-select" 
                                    id="editStatus<?php echo $task['id']; ?>" 
                                    name="status">
                                <option value="pending" <?php echo ($task['status'] === 'pending') ? 'selected' : ''; ?>>
                                    Bekliyor
                                </option>
                                <option value="completed" <?php echo ($task['status'] === 'completed') ? 'selected' : ''; ?>>
                                    Tamamlandı
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="close" class="btn btn-canc">
                            <i class="bi bi-x-circle"></i> İptal
                        </button>
                        <button type="submit" class="btn btn-upd">
                            <i class="bi bi-save"></i> Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include "../partials/index-footer.php" ?>
