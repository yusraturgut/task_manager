<?php
require_once "../config/db.php";

// Kullanıcı girişi kontrolü
require_once "../includes/auth_check.php"; 

$user_id = $_SESSION['user_id'];

// Görevleri çek
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);//SQL injection'a karşı koruma sağlamak için kullanılır
mysqli_stmt_bind_param($stmt, "i", $user_id);//UserID değerini ?yerine koyuyor
mysqli_stmt_execute($stmt);//SQL sorgusunu çalıştırıyor
$result = mysqli_stmt_get_result($stmt);//sonuçları alıyor 

$tasks = [];
while ($row = mysqli_fetch_assoc($result)) {//her satırı dizi şeklinde alır tasks dizisine ekler
    $tasks[] = $row;
}
mysqli_stmt_close($stmt);//sorgu kapatılır.

?> 

<?php include "../includes/header.php"; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Görevlerim</h3>
        <a href="add_task.php" class="btn btn-success">+ Yeni Görev</a>
    </div>

    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">Henüz bir göreviniz yok. Yeni görev ekleyebilirsiniz.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Durum</th>
                        <th>Oluşturulma</th>
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
            <span class="badge bg-success">Tamamlandı</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Bekliyor</span>
        <?php endif; ?>
    </td>
    <td><?php echo $task['created_at']; ?></td>
    <td>
        <!-- Düzenle Linki -->
        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Düzenle</a>

        <!-- Silme Formu -->
        <form method="POST" action="delete_task.php" style="display:inline;">
            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
            <button type="submit" class="btn btn-sm btn-danger" 
                    onclick="return confirm('Bu görevi silmek istediğinize emin misiniz?');">
                Sil
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

<?php include "../includes/footer.php"; ?>
